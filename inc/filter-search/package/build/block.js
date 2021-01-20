!function(e){var t={};function a(r){if(t[r])return t[r].exports;var n=t[r]={i:r,l:!1,exports:{}};return e[r].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.m=e,a.c=t,a.d=function(e,t,r){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)a.d(r,n,function(t){return e[t]}.bind(null,n));return r},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="",a(a.s=13)}([function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.blockEditor},function(e,t){e.exports=window.React},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.serverSideRender},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/filter-search","category":"vk-blocks-cat","attributes":{"TargetPostType":{"type":"string","default":""},"DisplayOnResult":{"type":"boolean","default":false},"DisplayOnPosttypeArchive":{"type":"string","default":"[]"},"FormID":{"type":"string","default":null},"PostID":{"type":"number","default":null}},"supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/keyword-search","category":"vk-blocks-cat","parent":["vk-filter-search/filter-search"],"supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/post-type-search","category":"vk-blocks-cat","parent":["vk-filter-search/filter-search"],"attributes":{"isCheckedPostType":{"type":"string","default":"[\\"post\\",\\"page\\"]"}},"supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/taxonomy-search","category":"vk-blocks-cat","parent":["vk-filter-search/filter-search"],"attributes":{"isSelectedTaxonomy":{"type":"string","default":"category"}},"supports":{"className":true}}')},function(e,t){e.exports=window.wp.blocks},function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.coreData},function(e,t){e.exports=window.wp.notices},function(e,t,a){"use strict";a.r(t),a.d(t,"__getVKFilterSearchBlocks",(function(){return se}));var r={};a.r(r),a.d(r,"metadata",(function(){return d})),a.d(r,"name",(function(){return T})),a.d(r,"settings",(function(){return S}));var n={};a.r(n),a.d(n,"metadata",(function(){return L})),a.d(n,"name",(function(){return H})),a.d(n,"settings",(function(){return F}));var c={};a.r(c),a.d(c,"metadata",(function(){return G})),a.d(c,"name",(function(){return W})),a.d(c,"settings",(function(){return X}));var l={};a.r(l),a.d(l,"metadata",(function(){return ne})),a.d(l,"name",(function(){return ce})),a.d(l,"settings",(function(){return le})),a(11),a(12);var s=a(9),i=a(2);function o(){return(o=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}var u=i.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),p=i.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),m=i.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),f=i.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"});function v(e){return i.createElement("svg",o({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),u,p,m,f)}var h=a(0),d=a(5),y=a(3),b=a(10);function _(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,r=new Array(t);a<t;a++)r[a]=e[a];return r}var k=function(e){var t,a,r=e.schema,n=e.rawData,c=e.checkedData,l=e.setAttributes,s=(t=Object(b.useState)(c),a=2,function(e){if(Array.isArray(e))return e}(t)||function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var a=[],r=!0,n=!1,c=void 0;try{for(var l,s=e[Symbol.iterator]();!(r=(l=s.next()).done)&&(a.push(l.value),!t||a.length!==t);r=!0);}catch(e){n=!0,c=e}finally{try{r||null==s.return||s.return()}finally{if(n)throw c}}return a}}(t,a)||function(e,t){if(e){if("string"==typeof e)return _(e,t);var a=Object.prototype.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?_(e,t):void 0}}(t,a)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),i=s[0],o=s[1];if(!n||!c)return!1;var u=function(e,t){var a,r,n;l((a={},r=e,n=JSON.stringify(t),r in a?Object.defineProperty(a,r,{value:n,enumerable:!0,configurable:!0,writable:!0}):a[r]=n,a))},p=n.map((function(e){return React.createElement(y.CheckboxControl,{key:e.slug,label:e.label,checked:i.some((function(t){return t===e.slug})),onChange:function(t){t?i.push(e.slug):function(e,t){var a=e.indexOf(t);-1!==a&&(e=e.splice(a,1))}(i,e.slug),o(i),u.bind(null,r,i)()}})}));return React.createElement("ul",null,p)},g=a(1);function E(){return(E=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}function R(){return(R=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}function O(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,r)}return a}function w(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?O(Object(a),!0).forEach((function(t){j(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):O(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function j(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}var P={TargetPostType:{type:"string",default:""}},x=[{attributes:w(w({},P),{},{DisplayOnResult:{type:"boolean",default:!1},DisplayOnPosttypeArchive:{type:"string",default:"[]"},FormID:{type:"string",default:null},PostID:{type:"number",default:null}}),save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=r.FormID;return t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,a,React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")}))}},{attributes:w(w({},P),{},{DisplayOnResult:{type:"boolean",default:!1},FormID:{type:"string",default:null}}),save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=r.FormID;return t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,a,React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")}))}},{attributes:w(w({},P),{},{DisplayOnResult:{type:"boolean",default:!1},PostID:{type:"number",default:null}}),save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=r.PostID;return t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,a,React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")}))}},{attributes:w(w({},P),{},{DisplayOnResult:{type:"boolean",default:!1}}),save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=wp.data.select("core/editor").getCurrentPostId();return t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},t,React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),a,React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")}))}},{attributes:w(w({},P),{},{DisplayOnResult:{type:"boolean",default:!1}}),save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=wp.data.select("core/editor").getCurrentPostId();return t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},t,React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),a,React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Refine search","vk-filter-search")}))}},{attributes:P,save:function(e){var t,a=e.attributes.TargetPostType;return t=""===a?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:a}),React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},t,React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Refine search","vk-filter-search")}))}},{attributes:P,save:function(e){var t,a=e.attributes.TargetPostType;return t=""===a?"":React.createElement("input",{type:"hidden",name:"post_type",value:a}),React.createElement("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},React.createElement("div",{className:"vkfs__labels"},t,React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Refine search","vk-filter-search")}))}}],T=d.name,S={title:Object(h.__)("VK Filter Search","vk-filter-search"),icon:React.createElement(v,null),example:{attributes:{TargetPostType:"post",DisplayOnResult:!1,FormID:null},innerBlocks:[{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"category"}},{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"post_tag"}},{name:"vk-filter-search/keyword-search"}]},edit:function(e){var t,a,r,n=e.attributes,c=e.setAttributes,l=e.clientId,s=n.TargetPostType,i=n.DisplayOnResult,o=n.DisplayOnPosttypeArchive,u=n.FormID,p=n.PostID;null==u&&c({FormID:l}),null==p&&c({PostID:wp.data.select("core/editor").getCurrentPostId()}),""===s?(t=["vk-filter-search/keyword-search","vk-filter-search/post-type-search","vk-filter-search/taxonomy-search"],a=""):(t=["vk-filter-search/keyword-search","vk-filter-search/taxonomy-search"],a=React.createElement("input",{type:"hidden",name:"post_type",value:s})),r=i?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:u}):"";var m=Object(g.useBlockProps)({className:"vk-filter-search vkfs"});return React.createElement(React.Fragment,null,React.createElement(g.InspectorControls,null,React.createElement(y.PanelBody,{title:Object(h.__)("Target of Post Type","vk-filter-search"),initialOpen:!0},React.createElement(y.BaseControl,{id:"vkfs-search-form-01"},React.createElement(y.SelectControl,{label:Object(h.__)("Target of Post Type","vk-filter-search"),value:s,options:vk_filter_search_post_type_select,onChange:function(e){return c({TargetPostType:e})}})),React.createElement(y.BaseControl,{id:"vkfs-search-form-02"},React.createElement(y.ToggleControl,{label:Object(h.__)("Display this form on search result page","vk-filter-search"),checked:i,onChange:function(e){return c({DisplayOnResult:e})}})),React.createElement(y.BaseControl,{id:"vkfs-search-form-03",label:Object(h.__)("Display on post type archive.","vk-filter-search")},React.createElement(k,E({schema:"DisplayOnPosttypeArchive",rawData:vk_filter_search_post_type_archive_checkbox,checkedData:JSON.parse(o)},e))))),React.createElement("form",E({},m,{method:"get",action:vk_filter_search_url}),React.createElement("div",{className:"vkfs__labels"},React.createElement(g.InnerBlocks,{allowedBlocks:t,templateLock:!1,template:[["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"category"}],["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"post_tag"}],["vk-filter-search/keyword-search"]]})),a,r,React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")})))},save:function(e){var t,a,r=e.attributes,n=r.TargetPostType,c=r.DisplayOnResult,l=r.FormID;t=""===n?"":React.createElement("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),a=c?React.createElement("input",{type:"hidden",name:"vkfs_form_id",value:l}):"";var s=g.useBlockProps.save({className:"vk-filter-search vkfs"});return React.createElement("form",R({},s,{method:"get",action:vk_filter_search_url}),React.createElement("div",{className:"vkfs__labels"},React.createElement(g.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,a,React.createElement("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),React.createElement("input",{className:"btn btn-primary",type:"submit",value:Object(h.__)("Search","vk-filter-search")}))},deprecated:x};function D(){return(D=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}var N=i.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),I=i.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),C=i.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),B=i.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"});function z(e){return i.createElement("svg",D({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),N,I,C,B)}var L=a(6),M=a(4),V=a.n(M),H=L.name,F={title:Object(h.__)("VK Keyword Search","vk-filter-search"),icon:React.createElement(z,null),edit:function(){var e=Object(g.useBlockProps)({className:"vkfs-keyword-search"});return React.createElement("div",e,React.createElement(V.a,{block:"vk-filter-search/keyword-search"}))}};function A(){return(A=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}var J=i.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),K=i.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),U=i.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),$=i.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"});function q(e){return i.createElement("svg",A({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),J,K,U,$)}var G=a(7);function Q(){return(Q=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}var W=G.name,X={title:Object(h.__)("VK Post Type Search","vk-filter-search"),icon:React.createElement(q,null),edit:function(e){var t,a=e.attributes.isCheckedPostType;t="[]"!==a?React.createElement(V.a,{block:"vk-filter-search/post-type-search",attributes:e.attributes}):React.createElement("div",{className:"vkfs_warning"},React.createElement("div",{className:"vkfs__label-name"},Object(h.__)("Post Type","vk-filter-search")),React.createElement("div",{className:"vkfs__warning-text"},Object(h.__)("Because no post type is selected, this block will not render.","vk-filter-search")));var r=Object(g.useBlockProps)({className:"vkfs-postType-search"});return React.createElement(React.Fragment,null,React.createElement(g.InspectorControls,null,React.createElement(y.PanelBody,{title:Object(h.__)("Post Type Option","vk-filter-search"),initialOpen:!0},React.createElement(y.BaseControl,{id:"vsfs02",label:Object(h.__)("Post Types","vk-filter-search")},React.createElement(k,Q({schema:"isCheckedPostType",rawData:vk_filter_search_post_type_checkbox,checkedData:JSON.parse(a)},e))))),React.createElement("div",r,t))}};function Y(){return(Y=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var r in a)Object.prototype.hasOwnProperty.call(a,r)&&(e[r]=a[r])}return e}).apply(this,arguments)}var Z=i.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),ee=i.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),te=i.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),ae=i.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"});function re(e){return i.createElement("svg",Y({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),Z,ee,te,ae)}var ne=a(8),ce=ne.name,le={title:Object(h.__)("VK Taxonomy Search","vk-filter-search"),icon:React.createElement(re,null),edit:function(e){var t,a=e.attributes,r=e.setAttributes,n=a.isSelectedTaxonomy,c=vk_filter_search_taxonomy_list.find((function(e){return e.value===n}));t=vk_filter_search_taxonomy_option.some((function(e){return e.value===n}))?React.createElement(V.a,{block:"vk-filter-search/taxonomy-search",attributes:e.attributes}):React.createElement("div",null,React.createElement("div",{className:"vkfs__warning"},React.createElement("div",{className:"vkfs__label-name"},c.label),React.createElement("div",{className:"vkfs__warning-text"},Object(h.__)("Because this taxonomy has no term, this block will not render.","vk-filter-search"))));var l=Object(g.useBlockProps)({className:"vkfs-taxonomy-search"});return React.createElement(React.Fragment,null,React.createElement(g.InspectorControls,null,React.createElement(y.PanelBody,{title:Object(h.__)("Taxonomy Option","vk-filter-search"),initialOpen:!0},React.createElement(y.BaseControl,{id:"vsfs03"},React.createElement(y.SelectControl,{label:Object(h.__)("Taxonomy","vk-filter-search"),value:n,options:vk_filter_search_taxonomy_option,onChange:function(e){return r({isSelectedTaxonomy:e})}})))),React.createElement("div",l,t))}},se=function(){return[r,n,c,l]};se().forEach((function(e){if(e){var t,a,r,n=e.metadata,c=e.settings,l=e.name;n&&Object(s.unstable__bootstrapServerSideBlockDefinitions)((r=n,(a=l)in(t={})?Object.defineProperty(t,a,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[a]=r,t)),Object(s.registerBlockType)(l,c)}}))}]);