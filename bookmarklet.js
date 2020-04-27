javascript:
	(function () {
		try {
			var serverUrl = 'https://put-here-your-own-server-url.com';
			var encode = function (str) {
				return btoa(encodeURIComponent(str));
			};

			var getData = function () {
				return encode(serverUrl + "?url=" + encode(document.URL) + "&description=" + encode(document.title));
			};

			var copyToClipboard = function(str) {
				const el = document.createElement("textarea");
				el.value = str;
				document.body.appendChild(el);
				el.select();
				document.execCommand("copy");
				document.body.removeChild(el);
			};
			
			var reqListener = function () {
				var returnedUrl = this.responseText;
				copyToClipboard(returnedUrl);
				prompt("Copy this URL to clipboard and paste it into a chat window", returnedUrl);
			};
			
			var makeGet = function (url, path) {
				var oReq = new XMLHttpRequest();
				oReq.addEventListener("load", reqListener);
				oReq.open("GET", url + path);
				oReq.setRequestHeader("destination-url", url);
				oReq.send();
			};

			makeGet(serverUrl, "?value=" + getData());
		} catch (e) {
			alert('There was an error: ' + e.message);
		}
	})()