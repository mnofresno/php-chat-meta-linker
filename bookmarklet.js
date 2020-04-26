javascript:(
	var serverUrl = 'https://put-here-your-own-server-url.com';
	function(){
		var getData = function () {
			return btoa(`${serverUrl}?url=${btoa(document.URL)}&description=${btoa(document.title)}`);
		};

		const copyToClipboard = function(str) {
			const el = document.createElement('textarea');el.value = str;
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
		};
		
		function reqListener () {
			var returnedUrl = this.responseText;
			copyToClipboard(returnedUrl);
			prompt("Copy this URL to clipboard and paste it into RocketChat", returnedUrl);
		}
		
		var makeGet = function(url, path) {
			var oReq = new XMLHttpRequest();
			oReq.addEventListener("load", reqListener);
			oReq.open("GET", url + path);
			oReq.setRequestHeader("destination-url", url);
			oReq.send();
		};
		makeGet(serverUrl, '?value=' + getData());
	}
)()
