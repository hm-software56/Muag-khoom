"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _ean_encoder = require("./ean_encoder.js");

var _ean_encoder2 = _interopRequireDefault(_ean_encoder);

var _Barcode2 = require("../Barcode.js");

var _Barcode3 = _interopRequireDefault(_Barcode2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; } // Encoding documentation:
// https://en.wikipedia.org/wiki/EAN_5#Encoding

var EAN5 = function (_Barcode) {
	_inherits(EAN5, _Barcode);

	function EAN5(data, options) {
		_classCallCheck(this, EAN5);

		// Define the EAN-13 structure
		var _this = _possibleConstructorReturn(this, _Barcode.call(this, data, options));

		_this.structure = ["GGLLL", "GLGLL", "GLLGL", "GLLLG", "LGGLL", "LLGGL", "LLLGG", "LGLGL", "LGLLG", "LLGLG"];
		return _this;
	}

	EAN5.prototype.valid = function valid() {
		return this.data.search(/^[0-9]{5}$/) !== -1;
	};

	EAN5.prototype.encode = function encode() {
		var encoder = new _ean_encoder2.default();
		var checksum = this.checksum();

		// Start bits
		var result = "1011";

		// Use normal ean encoding with 01 in between all digits
		result += encoder.encode(this.data, this.structure[checksum], "01");

		return {
			data: result,
			text: this.text
		};
	};

	EAN5.prototype.checksum = function checksum() {
		var result = 0;

		result += parseInt(this.data[0]) * 3;
		result += parseInt(this.data[1]) * 9;
		result += parseInt(this.data[2]) * 3;
		result += parseInt(this.data[3]) * 9;
		result += parseInt(this.data[4]) * 3;

		return result % 10;
	};

	return EAN5;
}(_Barcode3.default);

exports.default = EAN5;