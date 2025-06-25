/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./theme/assets/src/block-editor/plugins/hide-sections/index.js":
/*!**********************************************************************!*\
  !*** ./theme/assets/src/block-editor/plugins/hide-sections/index.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/edit-post */ "@wordpress/edit-post");
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_7__);



/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Wordpress Dependencies
 */








function HideSection(_ref) {
  let {
    settings,
    updateSectionsSettings
  } = _ref;

  /**
   * If you add a new property here, make sure to also add it
   * in the "properties" array at block-editor.php.
   */
  const settingsOptionsInitial = [{
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Hide Title', 'material'),
    key: 'title'
  }];
  settingsOptionsInitial.forEach(settingOption => {
    settingOption.value = settings[settingOption.key] ? settings[settingOption.key] : false;
  });
  const [settingsOptions, setSettingOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(settingsOptionsInitial);
  return react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__.PluginDocumentSettingPanel, {
    name: "sections-control",
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Hide Sections', 'material'),
    className: "custom-panel"
  }, settingsOptions.map(settingOption => {
    return react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.CheckboxControl, {
      checked: settings[settingOption.key] ? settings[settingOption.key] : false,
      onChange: state => {
        const newSettings = { ...settings
        };
        newSettings[settingOption.key] = state;
        const newSettingsOptions = settingsOptions;
        newSettingsOptions.forEach(newSettingOption => {
          if (newSettingOption.key === settingOption.key) {
            newSettingOption.value = state;
          }
        });
        updateSectionsSettings(newSettings);
        setSettingOptions(newSettingsOptions);
      },
      label: settingOption.label,
      key: settingOption.key
    });
  }));
}

const WrappedSectionControl = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.withSelect)(select => {
  const {
    getCurrentPostType
  } = select('core/editor');
  const {
    getPostType
  } = select('core');
  return {
    postTypeObj: getPostType(getCurrentPostType())
  };
}), (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__.ifCondition)(_ref2 => {
  var _postTypeObj$supports;

  let {
    postTypeObj
  } = _ref2;
  return postTypeObj === null || postTypeObj === void 0 ? void 0 : (_postTypeObj$supports = postTypeObj.supports) === null || _postTypeObj$supports === void 0 ? void 0 : _postTypeObj$supports['custom-fields'];
}), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.withSelect)(select => {
  const {
    getEditedPostAttribute
  } = select('core/editor');
  return {
    settings: getEditedPostAttribute('meta')['material-hide-sections']
  };
}), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.withDispatch)(dispatch => {
  return {
    updateSectionsSettings(settings) {
      dispatch('core/editor').editPost({
        meta: {
          'material-hide-sections': settings
        }
      });
    }

  };
}), (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_6__.ifCondition)(_ref3 => {
  let {
    settings
  } = _ref3;
  return !!settings;
})])(HideSection);
(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__.registerPlugin)('material-hide-sections', {
  render: WrappedSectionControl,
  icon: react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Icon, {
    icon: "admin-customizer"
  })
});

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/edit-post":
/*!**********************************!*\
  !*** external ["wp","editPost"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["editPost"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["plugins"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************************!*\
  !*** ./theme/assets/src/block-editor/index.js ***!
  \************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _plugins_hide_sections__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./plugins/hide-sections */ "./theme/assets/src/block-editor/plugins/hide-sections/index.js");
/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

})();

/******/ })()
;
//# sourceMappingURL=block-editor.js.map