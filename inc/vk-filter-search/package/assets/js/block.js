/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./inc/vk-filter-search/package/assets/_js/block.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./inc/vk-filter-search/package/assets/_js/block.js":
/*!**********************************************************!*\
  !*** ./inc/vk-filter-search/package/assets/_js/block.js ***!
  \**********************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/extends.js");
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _schema__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./schema */ "./inc/vk-filter-search/package/assets/_js/schema.js");
/* harmony import */ var _css_test_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../css/test.scss */ "./inc/vk-filter-search/package/assets/css/test.scss");
/* harmony import */ var _css_test_scss__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_css_test_scss__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _component__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./component */ "./inc/vk-filter-search/package/assets/_js/component.js");





var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    BaseControl = _wp$components.BaseControl,
    CheckboxControl = _wp$components.CheckboxControl;
var Fragment = wp.element.Fragment;
var InspectorControls = wp.blockEditor.InspectorControls;
var ServerSideRender = wp.serverSideRender;
registerBlockType('vk-filter-search/filter-search', {
  title: 'VK Filter Search',
  icon: Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("svg", {
    height: "25",
    viewBox: "0 0 24 25",
    width: "24",
    xmlns: "http://www.w3.org/2000/svg"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("path", {
    d: "m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",
    fill: "#000"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("path", {
    clipRule: "evenodd",
    d: "m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",
    fill: "#fff",
    fillRule: "evenodd"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("path", {
    d: "m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",
    fill: "#000"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("path", {
    d: "m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",
    fill: "#d8141c"
  })),
  category: 'vk-blocks-cat',
  attributes: _schema__WEBPACK_IMPORTED_MODULE_2__["schema"],
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var showKeyword = attributes.showKeyword,
        isCheckedPostType = attributes.isCheckedPostType,
        isCheckedTaxonomy = attributes.isCheckedTaxonomy;
    var postTypes = Object(_component__WEBPACK_IMPORTED_MODULE_4__["UsePostTypes"])();
    var postTypesProps = postTypes.map(function (postType) {
      return {
        label: postType.name,
        slug: postType.slug
      };
    });
    var taxonomies = Object(_component__WEBPACK_IMPORTED_MODULE_4__["UseTaxonomies"])();
    var taxonomiesProps = taxonomies.map(function (taxonomy) {
      return {
        label: taxonomy.name,
        slug: taxonomy.slug
      };
    });
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(InspectorControls, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(PanelBody, {
      title: __('Filtering Options', 'vk-filter-search'),
      initialOpen: false
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(BaseControl, {
      id: 'vsfs01',
      label: __('Keyword', 'vk-filter-search')
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(CheckboxControl, {
      label: __('Filter by Keyword', 'vk-filter-search'),
      className: 'mb-1',
      checked: showKeyword,
      onChange: function onChange(checked) {
        return setAttributes({
          showKeyword: checked
        });
      }
    })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(BaseControl, {
      id: 'vsfs02',
      label: __('Post Types', 'vk-filter-search')
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(_component__WEBPACK_IMPORTED_MODULE_4__["AdvancedCheckboxControl"], _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0___default()({
      schema: 'isCheckedPostType',
      rawData: postTypesProps,
      checkedData: JSON.parse(isCheckedPostType)
    }, props))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(BaseControl, {
      id: 'vsfs03',
      label: __('Taxonomies', 'vk-filter-search')
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(_component__WEBPACK_IMPORTED_MODULE_4__["AdvancedCheckboxControl"], _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0___default()({
      schema: 'isCheckedTaxonomy',
      rawData: taxonomiesProps,
      checkedData: JSON.parse(isCheckedTaxonomy)
    }, props))))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(ServerSideRender, {
      block: "vk-filter-search/filter-search",
      attributes: props.attributes
    }));
  }
});

/***/ }),

/***/ "./inc/vk-filter-search/package/assets/_js/component.js":
/*!**************************************************************!*\
  !*** ./inc/vk-filter-search/package/assets/_js/component.js ***!
  \**************************************************************/
/*! exports provided: UsePostTypes, UseTaxonomies, destructiveDeleteFromArray, AdvancedCheckboxControl */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UsePostTypes", function() { return UsePostTypes; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UseTaxonomies", function() { return UseTaxonomies; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "destructiveDeleteFromArray", function() { return destructiveDeleteFromArray; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AdvancedCheckboxControl", function() { return AdvancedCheckboxControl; });
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);






var UsePostTypes = function UsePostTypes() {
  return Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__["useSelect"])(function (select) {
    return select('core').getPostTypes({
      per_page: -1
    }) || [];
  }, []);
};
var UseTaxonomies = function UseTaxonomies() {
  return Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__["useSelect"])(function (select) {
    return select('core').getTaxonomies({
      per_page: -1
    }) || [];
  }, []);
};
var destructiveDeleteFromArray = function destructiveDeleteFromArray(array, value) {
  var index = array.indexOf(value);
  index !== -1 && array.splice(index, 1);
};
var AdvancedCheckboxControl = function AdvancedCheckboxControl(props) {
  var schema = props.schema,
      rawData = props.rawData,
      checkedData = props.checkedData,
      setAttributes = props.setAttributes;

  var _useState = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__["useState"])(checkedData),
      _useState2 = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default()(_useState, 2),
      checkedState = _useState2[0],
      setCheckedState = _useState2[1];

  if (!rawData || !checkedData) return false;

  var advancedSetAttributes = function advancedSetAttributes(schema2, saveData) {
    setAttributes(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()({}, schema2, JSON.stringify(saveData)));
  };

  var checkBoxComponents = rawData.map(function (data) {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__["CheckboxControl"], {
      key: data.slug,
      label: data.label,
      checked: checkedState.some(function (item) {
        return item === data.slug;
      }),
      onChange: function onChange(value) {
        if (value) {
          checkedState.push(data.slug);
        } else {
          destructiveDeleteFromArray(checkedState, data.slug);
        }

        setCheckedState(checkedState);
        advancedSetAttributes.bind(null, schema, checkedState)();
      }
    });
  });
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__["createElement"])("ul", null, checkBoxComponents);
};

/***/ }),

/***/ "./inc/vk-filter-search/package/assets/_js/schema.js":
/*!***********************************************************!*\
  !*** ./inc/vk-filter-search/package/assets/_js/schema.js ***!
  \***********************************************************/
/*! exports provided: schema */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "schema", function() { return schema; });
var schema = {
  showKeyword: {
    type: 'boolean',
    default: true
  },
  isCheckedPostType: {
    type: 'string',
    default: '["post","page"]'
  },
  isCheckedTaxonomy: {
    type: 'string',
    default: '["category","post_tag"]'
  }
};

/***/ }),

/***/ "./inc/vk-filter-search/package/assets/css/test.scss":
/*!***********************************************************!*\
  !*** ./inc/vk-filter-search/package/assets/css/test.scss ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/extends.js":
/*!********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/extends.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _extends() {
  module.exports = _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

module.exports = _extends;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _iterableToArrayLimit(arr, i) {
  if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");

var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableRest = __webpack_require__(/*! ./nonIterableRest */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;

/***/ }),

/***/ "@wordpress/components":
/*!*********************************************!*\
  !*** external {"this":["wp","components"]} ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["components"]; }());

/***/ }),

/***/ "@wordpress/data":
/*!***************************************!*\
  !*** external {"this":["wp","data"]} ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["data"]; }());

/***/ }),

/***/ "@wordpress/element":
/*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["element"]; }());

/***/ })

/******/ });
//# sourceMappingURL=block.js.map