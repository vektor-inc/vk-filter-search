(window.webpackJsonp_vk_filter_search=window.webpackJsonp_vk_filter_search||[]).push([[1],{16:function(e,t,r){}}]),function(e){function t(t){for(var a,l,s=t[0],i=t[1],o=t[2],p=0,f=[];p<s.length;p++)l=s[p],Object.prototype.hasOwnProperty.call(n,l)&&n[l]&&f.push(n[l][0]),n[l]=0;for(a in i)Object.prototype.hasOwnProperty.call(i,a)&&(e[a]=i[a]);for(u&&u(t);f.length;)f.shift()();return c.push.apply(c,o||[]),r()}function r(){for(var e,t=0;t<c.length;t++){for(var r=c[t],a=!0,s=1;s<r.length;s++){var i=r[s];0!==n[i]&&(a=!1)}a&&(c.splice(t--,1),e=l(l.s=r[0]))}return e}var a={},n={0:0},c=[];function l(t){if(a[t])return a[t].exports;var r=a[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,l),r.l=!0,r.exports}l.m=e,l.c=a,l.d=function(e,t,r){l.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},l.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(e,t){if(1&t&&(e=l(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(l.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)l.d(r,a,function(t){return e[t]}.bind(null,a));return r},l.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return l.d(t,"a",t),t},l.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},l.p="";var s=window.webpackJsonp_vk_filter_search=window.webpackJsonp_vk_filter_search||[],i=s.push.bind(s);s.push=t,s=s.slice();for(var o=0;o<s.length;o++)t(s[o]);var u=i;c.push([23,1]),r()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.blockEditor},function(e,t){e.exports=window.React},function(e,t){e.exports=window.wp.components},function(e,t){function r(){return e.exports=r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)Object.prototype.hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e},r.apply(this,arguments)}e.exports=r},function(e,t){e.exports=function(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}},function(e,t){e.exports=window.wp.serverSideRender},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/filter-search","category":"vk-blocks-cat","attributes":{"TargetPostType":{"type":"string","default":""},"DisplayOnResult":{"type":"boolean","default":false},"DisplayOnPosttypeArchive":{"type":"string","default":"[]"},"FormID":{"type":"string","default":null},"PostID":{"type":"number","default":null}},"supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/keyword-search","category":"vk-blocks-cat","parent":"[\'vk-filter-search/filter-search\']","supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/post-type-search","category":"vk-blocks-cat","parent":"[\'vk-filter-search/filter-search\']","attributes":{"isCheckedPostType":{"type":"string","default":"[\\"post\\",\\"page\\"]"}},"supports":{"className":true}}')},function(e){e.exports=JSON.parse('{"apiVersion":2,"name":"vk-filter-search/taxonomy-search","category":"vk-blocks-cat","parent":"[\'vk-filter-search/filter-search\']","attributes":{"isSelectedTaxonomy":{"type":"string","default":"category"}},"supports":{"className":true}}')},function(e,t){e.exports=window.wp.blocks},function(e,t,r){var a=r(18),n=r(19),c=r(20),l=r(22);e.exports=function(e,t){return a(e)||n(e,t)||c(e,t)||l()}},function(e,t){e.exports=window.wp.coreData},function(e,t){e.exports=window.wp.notices},,function(e,t,r){},function(e,t){e.exports=function(e){if(Array.isArray(e))return e}},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var r=[],a=!0,n=!1,c=void 0;try{for(var l,s=e[Symbol.iterator]();!(a=(l=s.next()).done)&&(r.push(l.value),!t||r.length!==t);a=!0);}catch(e){n=!0,c=e}finally{try{a||null==s.return||s.return()}finally{if(n)throw c}}return r}}},function(e,t,r){var a=r(21);e.exports=function(e,t){if(e){if("string"==typeof e)return a(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?a(e,t):void 0}}},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,a=new Array(t);r<t;r++)a[r]=e[r];return a}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(e,t,r){"use strict";r.r(t),r.d(t,"__getVKFilterSearchBlocks",(function(){return ne}));var a={};r.r(a),r.d(a,"metadata",(function(){return y})),r.d(a,"name",(function(){return D})),r.d(a,"settings",(function(){return N}));var n={};r.r(n),r.d(n,"metadata",(function(){return M})),r.d(n,"name",(function(){return H})),r.d(n,"settings",(function(){return F}));var c={};r.r(c),r.d(c,"metadata",(function(){return q})),r.d(c,"name",(function(){return G})),r.d(c,"settings",(function(){return Q}));var l={};r.r(l),r.d(l,"metadata",(function(){return te})),r.d(l,"name",(function(){return re})),r.d(l,"settings",(function(){return ae}));var s=r(6),i=r.n(s),o=(r(14),r(15),r(12)),u=r(0),p=(r(16),r(17),r(3));function f(){return(f=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)Object.prototype.hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e}).apply(this,arguments)}var m=p.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),h=p.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),v=p.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),b=p.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"}),d=r(1),y=r(8),_=r(5),O=r.n(_),k=r(13),j=r.n(k),g=r(4),E=function(e){var t=e.schema,r=e.rawData,a=e.checkedData,n=e.setAttributes,c=Object(u.useState)(a),l=j()(c,2),s=l[0],o=l[1];if(!r||!a)return!1;var p=function(e,t){n(i()({},e,JSON.stringify(t)))},f=r.map((function(e){return Object(u.createElement)(g.CheckboxControl,{key:e.slug,label:e.label,checked:s.some((function(t){return t===e.slug})),onChange:function(r){r?s.push(e.slug):function(e,t){var r=e.indexOf(t);-1!==r&&(e=e.splice(r,1))}(s,e.slug),o(s),p.bind(null,t,s)()}})}));return Object(u.createElement)("ul",null,f)},w=r(2);function x(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function P(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?x(Object(r),!0).forEach((function(t){i()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):x(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var S={TargetPostType:{type:"string",default:""}},T=[{attributes:P(P({},S),{},{DisplayOnResult:{type:"boolean",default:!1},DisplayOnPosttypeArchive:{type:"string",default:"[]"},FormID:{type:"string",default:null},PostID:{type:"number",default:null}}),save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=a.FormID;return t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,r,Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")}))}},{attributes:P(P({},S),{},{DisplayOnResult:{type:"boolean",default:!1},FormID:{type:"string",default:null}}),save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=a.FormID;return t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,r,Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")}))}},{attributes:P(P({},S),{},{DisplayOnResult:{type:"boolean",default:!1},PostID:{type:"number",default:null}}),save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=a.PostID;return t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,r,Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")}))}},{attributes:P(P({},S),{},{DisplayOnResult:{type:"boolean",default:!1}}),save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=wp.data.select("core/editor").getCurrentPostId();return t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},t,Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),r,Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")}))}},{attributes:P(P({},S),{},{DisplayOnResult:{type:"boolean",default:!1}}),save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=wp.data.select("core/editor").getCurrentPostId();return t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"",Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},t,Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),r,Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Refine search","vk-filter-search")}))}},{attributes:S,save:function(e){var t,r=e.attributes.TargetPostType;return t=""===r?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:r}),Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},t,Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Refine search","vk-filter-search")}))}},{attributes:S,save:function(e){var t,r=e.attributes.TargetPostType;return t=""===r?"":Object(u.createElement)("input",{type:"hidden",name:"post_type",value:r}),Object(u.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(u.createElement)("div",{className:"vkfs__labels"},t,Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Refine search","vk-filter-search")}))}}],D=y.name,N={title:Object(d.__)("VK Filter Search","vk-filter-search"),icon:Object(u.createElement)((function(e){return p.createElement("svg",f({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),m,h,v,b)}),null),example:{attributes:{TargetPostType:"post",DisplayOnResult:!1,FormID:null},innerBlocks:[{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"category"}},{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"post_tag"}},{name:"vk-filter-search/keyword-search"}]},edit:function(e){var t,r,a,n=e.attributes,c=e.setAttributes,l=e.clientId,s=n.TargetPostType,i=n.DisplayOnResult,o=n.DisplayOnPosttypeArchive,p=n.FormID,f=n.PostID;null==p&&c({FormID:l}),null==f&&c({PostID:wp.data.select("core/editor").getCurrentPostId()}),""===s?(t=["vk-filter-search/keyword-search","vk-filter-search/post-type-search","vk-filter-search/taxonomy-search"],r=""):(t=["vk-filter-search/keyword-search","vk-filter-search/taxonomy-search"],r=Object(u.createElement)("input",{type:"hidden",name:"post_type",value:s})),a=i?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:p}):"";var m=Object(w.useBlockProps)({className:"vk-filter-search vkfs"});return Object(u.createElement)(u.Fragment,null,Object(u.createElement)(w.InspectorControls,null,Object(u.createElement)(g.PanelBody,{title:Object(d.__)("Target of Post Type","vk-filter-search"),initialOpen:!0},Object(u.createElement)(g.BaseControl,{id:"vkfs-search-form-01"},Object(u.createElement)(g.SelectControl,{label:Object(d.__)("Target of Post Type","vk-filter-search"),value:s,options:vk_filter_search_post_type_select,onChange:function(e){return c({TargetPostType:e})}})),Object(u.createElement)(g.BaseControl,{id:"vkfs-search-form-02"},Object(u.createElement)(g.ToggleControl,{label:Object(d.__)("Display this form on search result page","vk-filter-search"),checked:i,onChange:function(e){return c({DisplayOnResult:e})}})),Object(u.createElement)(g.BaseControl,{id:"vkfs-search-form-03",label:Object(d.__)("Display on post type archive.","vk-filter-search")},Object(u.createElement)(E,O()({schema:"DisplayOnPosttypeArchive",rawData:vk_filter_search_post_type_archive_checkbox,checkedData:JSON.parse(o)},e))))),Object(u.createElement)("form",O()({},m,{method:"get",action:vk_filter_search_url}),Object(u.createElement)("div",{className:"vkfs__labels"},Object(u.createElement)(w.InnerBlocks,{allowedBlocks:t,templateLock:!1,template:[["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"category"}],["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"post_tag"}],["vk-filter-search/keyword-search"]]})),r,a,Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")})))},save:function(e){var t,r,a=e.attributes,n=a.TargetPostType,c=a.DisplayOnResult,l=a.FormID;t=""===n?"":Object(u.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:n}),r=c?Object(u.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}):"";var s=w.useBlockProps.save({className:"vk-filter-search vkfs"});return Object(u.createElement)("form",O()({},s,{method:"get",action:vk_filter_search_url}),Object(u.createElement)("div",{className:"vkfs__labels"},Object(u.createElement)(w.InnerBlocks.Content,null)),"[no_keyword_hidden_input]",t,r,Object(u.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(u.createElement)("input",{className:"btn btn-primary",type:"submit",value:Object(d.__)("Search","vk-filter-search")}))},deprecated:T};function I(){return(I=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)Object.prototype.hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e}).apply(this,arguments)}var C=p.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),z=p.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),B=p.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),L=p.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"}),M=r(9),V=r(7),R=r.n(V),H=M.name,F={title:Object(d.__)("VK Keyword Search","vk-filter-search"),icon:Object(u.createElement)((function(e){return p.createElement("svg",I({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),C,z,B,L)}),null),edit:function(){return Object(u.createElement)(R.a,{block:"vk-filter-search/keyword-search"})}};function A(){return(A=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)Object.prototype.hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e}).apply(this,arguments)}var J=p.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),K=p.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),U=p.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),$=p.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"}),q=r(10),G=q.name,Q={title:Object(d.__)("VK Post Type Search","vk-filter-search"),icon:Object(u.createElement)((function(e){return p.createElement("svg",A({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),J,K,U,$)}),null),edit:function(e){var t,r=e.attributes.isCheckedPostType;return t="[]"!==r?Object(u.createElement)(R.a,{block:"vk-filter-search/post-type-search",attributes:e.attributes}):Object(u.createElement)("div",null,Object(u.createElement)("div",{className:"vkfs_warning"},Object(u.createElement)("div",{className:"vkfs__label-name"},Object(d.__)("Post Type","vk-filter-search")),Object(u.createElement)("div",{className:"vkfs__warning-text"},Object(d.__)("Because no post type is selected, this block will not render.","vk-filter-search")))),Object(u.createElement)(u.Fragment,null,Object(u.createElement)(w.InspectorControls,null,Object(u.createElement)(g.PanelBody,{title:Object(d.__)("Post Type Option","vk-filter-search"),initialOpen:!0},Object(u.createElement)(g.BaseControl,{id:"vsfs02",label:Object(d.__)("Post Types","vk-filter-search")},Object(u.createElement)(E,O()({schema:"isCheckedPostType",rawData:vk_filter_search_post_type_checkbox,checkedData:JSON.parse(r)},e))))),t)}};function W(){return(W=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)Object.prototype.hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e}).apply(this,arguments)}var X=p.createElement("path",{d:"M19.111 4H4.89c-.236 0-.462.089-.629.247S4 4.619 4 4.842v2.181c0 .44.19.873.518 1.185l4.815 4.562v6.388c0 .143.04.284.113.41s.18.23.31.306a.925.925 0 00.864.038l3.555-1.684a.84.84 0 00.492-.754V12.77l4.815-4.562c.329-.312.518-.744.518-1.185v-2.18c0-.224-.094-.438-.26-.596S19.347 4 19.11 4zm-5.642 7.826c-.082.078-.148.17-.193.273s-.067.212-.067.322l-.025 4.76-2.382 1.105V12.42a.83.83 0 00-.26-.595L5.469 7.023V5.371h13.062v1.652z"}),Y=p.createElement("path",{d:"M9.9 14.116c1.408 0 2.128 1.694 1.158 2.709L8.88 19.117l.963 3.104c.302.965-.38 2.078-1.525 2.078H5.33c-.838 0-1.357-.607-1.521-1.116l-.013-.04-.36-1.37a1.599 1.599 0 01.02-.919l.005-.017.242-.696H2.649l2.702-2.909a1.687 1.687 0 01-.182-1.302l.011-.037.237-.685a1.6 1.6 0 011.51-1.086h.003zm-2.97 1.507a.102.102 0 00-.093.07l-.227.655c-.02.07.027.139.094.139h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581a.096.096 0 00-.126-.068.1.1 0 00-.061.06l-.387 1.113a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173zm-.097.014l-.002.003z",fill:"#fff"}),Z=p.createElement("path",{d:"M9.9 15.616l-2.97.007a.1.1 0 00-.093.07l-.227.656c-.02.069.027.138.094.138h1.154c.087 0 .133.11.073.172L6.09 18.642h.006l.948 3.087c.02.07-.027.132-.094.132h-.927a.095.095 0 01-.093-.07l-.474-1.581c-.027-.097-.154-.097-.187-.007l-.387 1.112a.1.1 0 000 .062l.354 1.347c.013.041.053.076.093.076h2.99c.066 0 .113-.07.093-.131l-1.208-3.89c-.013-.034 0-.075.027-.103l2.742-2.887c.06-.062.013-.173-.073-.173z"}),ee=p.createElement("path",{d:"M6.383 14l-1.808.007a.1.1 0 00-.093.069l-.234.656a.102.102 0 00.094.138h.76c.067 0 .114.07.094.139L3.04 21.114a.098.098 0 01-.187 0l-1.548-4.406a.102.102 0 01.093-.138h.78a.1.1 0 01.094.069l.56 1.588c.034.09.154.09.188 0l.867-2.473a.102.102 0 00-.094-.138H.098c-.067 0-.113.07-.093.138l2.842 8.179c.033.09.153.09.187 0l3.443-9.795c.02-.069-.027-.138-.094-.138z",fill:"#d8141c"}),te=r(11),re=te.name,ae={title:Object(d.__)("VK Taxonomy Search","vk-filter-search"),icon:Object(u.createElement)((function(e){return p.createElement("svg",W({height:25,width:24,xmlns:"http://www.w3.org/2000/svg"},e),X,Y,Z,ee)}),null),edit:function(e){var t,r=e.attributes,a=e.setAttributes,n=r.isSelectedTaxonomy,c=vk_filter_search_taxonomy_list.find((function(e){return e.value===n}));return t=vk_filter_search_taxonomy_option.some((function(e){return e.value===n}))?Object(u.createElement)(R.a,{block:"vk-filter-search/taxonomy-search",attributes:e.attributes}):Object(u.createElement)("div",null,Object(u.createElement)("div",{className:"vkfs__warning"},Object(u.createElement)("div",{className:"vkfs__label-name"},c.label),Object(u.createElement)("div",{className:"vkfs__warning-text"},Object(d.__)("Because this taxonomy has no term, this block will not render.","vk-filter-search")))),Object(u.createElement)(u.Fragment,null,Object(u.createElement)(w.InspectorControls,null,Object(u.createElement)(g.PanelBody,{title:Object(d.__)("Taxonomy Option","vk-filter-search"),initialOpen:!0},Object(u.createElement)(g.BaseControl,{id:"vsfs03"},Object(u.createElement)(g.SelectControl,{label:Object(d.__)("Taxonomy","vk-filter-search"),value:n,options:vk_filter_search_taxonomy_option,onChange:function(e){return a({isSelectedTaxonomy:e})}})))),t)}},ne=function(){return[a,n,c,l]};ne().forEach((function(e){if(e){var t=e.metadata,r=e.settings,a=e.name;t&&Object(o.unstable__bootstrapServerSideBlockDefinitions)(i()({},a,t)),Object(o.registerBlockType)(a,r)}}))}]);