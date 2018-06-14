class Cookie {
	constructor(name) {
		this.cname = name;
	}
	
	read() {
		let name = this.cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i <ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return null;
	}

	/**
	 * Writes the cookie value
	 *
	 * @param {string} cvalue The value to be written
	 * @param {boolean|number} exdays Expiration of the cookie in days, false for session only
	 */
	write(cvalue, exdays = false) {
		let d = new Date();
		let expires = '';
		if(exdays !== false) {
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			expires = `expires=${d.toUTCString()};`;
		}
		document.cookie = `${this.cname}=${cvalue};${expires}path=/`;
	}
}

export default Cookie;