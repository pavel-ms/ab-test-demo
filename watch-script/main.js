(function(w) {
	if (!w) {
		throw "The library must be executed in browser env";
	}

	// external libs
	var Q = null
		, cookie = null;

	// main context of the AB-test object
	var self = null;

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

	var _sendData = function(url, data) {
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
		for (var d in data) {
			params += (d + '=' + data[d]);
		}
		params === ''
			? params = 'cb=' + callbackName
			: params += '&cb=' + callbackName;
		s.src = url + '?' + w.encodeURI(params);

		return dfr.promise;
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
			// получим данные
			_sendData('/static/test.js', {foo: 'bar'}).then(function(res) {
				console.dir(res);
			});
		}
	};

	// создадим глобальный объект AbTest
	if (typeof w.$__Ab_Test === 'undefined') {
		w.$__Ab_Test = AbTest;
	}

})(typeof window === 'object' ? window : false);