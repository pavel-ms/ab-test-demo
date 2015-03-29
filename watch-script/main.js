(function(w) {
	if (!w) {
		throw "The library must be executed in browser env";
	}

	// external libs
	var Q = null
		, cookie = null;

    var ROOT_URL = '//calm-meadow-1664.herokuapp.com/index.php?r=analytics/';
    var COOKIE_KEY = '$$__ab_test_variant';

    var BOOTSTRAP_PAGE = 'bootstrap';
    var VARIANT_A = 'a';
    var VARIANT_B = 'b';
    var SUCCESS_PAGE = 'success';

	// main context of the AB-test object
	var self = null;

    // ab-test settings
    var _settings = {};

	/**
	 * Создает и инсертит элемент script в DOM
	 * @returns {HTMLElement}
	 * @private
	 */
	var _createJsonpScript = function() {
		var script = w.document.createElement('script');
		w.document.head.appendChild(script);

		return script;
	};

	/**
	 * Удаляет элемент script из DOM
	 * @param script
	 * @private
	 */
	var _destroyJsonpScript = function(script) {
		script.parentNode.removeChild(script);
	};

	var _requestServer = function(url, data) {
		var s = _createJsonpScript()
			, params = ''
			, dfr = Q.defer()
			, response = false
			, cb
			, callbackName
			, indx;

		// применяем замыкание, чтобы сохранить данные, полученные с сервера
		cb = function(data) {
			response = data;
		};

		// пушним колбек в переменную, чтобы можно было сгенерить имя от глобального объекта
		indx = self._functionsStore.push(cb);
		callbackName = 'window.$__ab_Test._functionsStore[' + (indx - 1).toString() + ']';

		// решим промис данными, функция cb уже выполнена
		s.onload = function(data) {
			_destroyJsonpScript(s);
			dfr.resolve(response);
		};
		// создадим GET строку запроса
        data['cb'] = callbackName;
        params = _buildQueryString(data);

		s.src = url + '&' + params;

		return dfr.promise;
	};

    /**
     * Хелпер, который возвращает uri от url
     * @private
     */
    var _extractUri = function(url) {
        return url
            .replace(w.location.protocol, '')
            //.replace(':' + w.location.port, '')
            .replace(w.location.host, '');
    };

    /**
     * Функция хелпер - редиректит браузер на указанный url
     * @param url
     * @private
     */
    var _redirect = function(url) {
        w.location.href = url;
    };

    /**
     * Собираем query string из объекта
     *
     * @param data
     * @return {string}
     * @private
     */
    var _buildQueryString = function(data) {
        var ret = [];
        for (var d in data)
            ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));

        return ret.join("&");
    };

	/**
	 * Main object
	 *
	 * @param options
	 * @constructor
	 */
	var AbTest = function(options) {
		if (!options.id) {
			throw "AB-Test: set param `id` for main script";
		}
		self = this;
		self.id = options.id;

		this.init();
	};
	AbTest.prototype = {
		/**
		 * Инициализация компонента
		 */
		init: function() {
			Q = AbTest.Q;
			cookie = AbTest.cookie;
			self._functionsStore = [];
            self
                .getSettings()
                .then(function() {
                    self.processAbTest();
                });
		},

        /**
         * Receives settings from server
         */
        getSettings: function() {
            var dfr = Q.defer();
            _requestServer(ROOT_URL+'settings', {id: self.id})
                .then(function(res) {
                    _settings = res;
                    console.dir(_settings);
                    dfr.resolve();
                }, function() { dfr.reject(); });

            return dfr.promise;
        },

        /**
         * Возвращает действие, которое необходимо выполнить в зависимости от текущего url
         * @return
         */
        getAction: function() {
            var uri = w.location.pathname;
            console.log('url:');
            console.log(_extractUri(_settings['bootstrap_url']));

            if (uri === _extractUri(_settings['bootstrap_url'])) {
                return BOOTSTRAP_PAGE;
            } else if (uri === _extractUri(_settings['a_url'])) {
                return VARIANT_A;
            } else if (uri === _extractUri(_settings['b_url'])) {
                return VARIANT_B;
            } else if (_extractUri(_settings['success_url'])) {
                return SUCCESS_PAGE;
            } else {
                return false;
            }
        },

        /**
         * Process work
         */
        processAbTest: function() {
            var currentDomain = w.location.host;
            //if (_settings.bootstrap_url.indexOf(currentDomain) === -1) {
            //    throw "AB-Test: Wrong domain";
            //}
            console.log('Action: '+self.getAction());
            switch(self.getAction()) {
                case(BOOTSTRAP_PAGE):
                    self.goToVariant();
                    break;
                case(VARIANT_A):
                    self.handleVariant(VARIANT_A);
                    break;
                case(VARIANT_B):
                    self.handleVariant(VARIANT_B);
                    break;
                case(SUCCESS_PAGE):
                    self.handleSuccess();
                    break;
                default:
                    console.log('no action');
                    break;
            }
        },

        /**
         * Отправляет к конкретному варианту
         */
        goToVariant: function() {
            var max = 100
                , min = 0
                , variant = (Math.floor(Math.random() * (max - min + 1)) + min) % 2
                , newLocation;
            newLocation = variant === 0
                ? _settings['a_url']
                : _settings['b_url'];

            _redirect(_extractUri(newLocation));
        },

        /**
         * Обрабатывает показ варианта
         */
        handleVariant: function(variant) {
            // Запоминаем какой вариант был просмотрен
            cookie.set(COOKIE_KEY, variant);

            // отправить данные о просмотре варианта
            _requestServer(ROOT_URL + 'grab-data', {
                action: 'show'
                , variant: variant
                , id: self.id
            });
        },

        /**
         * Отправляет результат показа
         */
        handleSuccess: function() {
            var variant = cookie.get(COOKIE_KEY);
            _requestServer(ROOT_URL + 'grab-data', {
                action: 'success'
                , variant: variant
                , id: self.id
            });
        }
	};

	// создадим глобальный объект AbTest
	if (typeof w.$__Ab_Test === 'undefined') {
		w.$__Ab_Test = AbTest;
	}

})(typeof window === 'object' ? window : false);