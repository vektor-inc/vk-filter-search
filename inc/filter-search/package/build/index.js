(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{8:function(e,t,c){}}]),function(e){function t(t){for(var r,a,o=t[0],i=t[1],s=t[2],f=0,h=[];f<o.length;f++)a=o[f],Object.prototype.hasOwnProperty.call(l,a)&&l[a]&&h.push(l[a][0]),l[a]=0;for(r in i)Object.prototype.hasOwnProperty.call(i,r)&&(e[r]=i[r]);for(u&&u(t);h.length;)h.shift()();return n.push.apply(n,s||[]),c()}function c(){for(var e,t=0;t<n.length;t++){for(var c=n[t],r=!0,o=1;o<c.length;o++){var i=c[o];0!==l[i]&&(r=!1)}r&&(n.splice(t--,1),e=a(a.s=c[0]))}return e}var r={},l={0:0},n=[];function a(t){if(r[t])return r[t].exports;var c=r[t]={i:t,l:!1,exports:{}};return e[t].call(c.exports,c,c.exports,a),c.l=!0,c.exports}a.m=e,a.c=r,a.d=function(e,t,c){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:c})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var c=Object.create(null);if(a.r(c),Object.defineProperty(c,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)a.d(c,r,function(t){return e[t]}.bind(null,r));return c},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="";var o=window.webpackJsonp=window.webpackJsonp||[],i=o.push.bind(o);o.push=t,o=o.slice();for(var s=0;s<o.length;s++)t(o[s]);var u=i;n.push([7,1]),c()}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t,c){"use strict";c.d(t,"b",(function(){return h})),c.d(t,"c",(function(){return p})),c.d(t,"d",(function(){return m})),c.d(t,"a",(function(){return v}));var r=c(3),l=c.n(r),n=c(4),a=c.n(n),o=c(0),i=c(2),s=c(5);function u(e,t){var c;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(c=function(e,t){if(!e)return;if("string"==typeof e)return f(e,t);var c=Object.prototype.toString.call(e).slice(8,-1);"Object"===c&&e.constructor&&(c=e.constructor.name);if("Map"===c||"Set"===c)return Array.from(e);if("Arguments"===c||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(c))return f(e,t)}(e))||t&&e&&"number"==typeof e.length){c&&(e=c);var r=0,l=function(){};return{s:l,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:l}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var n,a=!0,o=!1;return{s:function(){c=e[Symbol.iterator]()},n:function(){var e=c.next();return a=e.done,e},e:function(e){o=!0,n=e},f:function(){try{a||null==c.return||c.return()}finally{if(o)throw n}}}}function f(e,t){(null==t||t>e.length)&&(t=e.length);for(var c=0,r=new Array(t);c<t;c++)r[c]=e[c];return r}var h=function(){return Object(i.useSelect)((function(e){return e("core").getPostTypes({per_page:-1})||[]}),[])},p=function(){return Object(i.useSelect)((function(e){return e("core").getTaxonomies({per_page:-1})||[]}),[])},m=function(e){return Object(i.useSelect)((function(t){var c,r={},l=u(e);try{for(l.s();!(c=l.n()).done;){var n=c.value;r[n.rest_base]=t("core").getEntityRecords("taxonomy",n.slug,{per_page:-1})||[]}}catch(e){l.e(e)}finally{l.f()}return r}),[e])},v=function(e){var t=e.schema,c=e.rawData,r=e.checkedData,n=e.setAttributes,i=Object(o.useState)(r),u=a()(i,2),f=u[0],h=u[1];if(!c||!r)return!1;var p=function(e,t){n(l()({},e,JSON.stringify(t)))},m=c.map((function(e){return Object(o.createElement)(s.CheckboxControl,{key:e.slug,label:e.label,checked:f.some((function(t){return t===e.slug})),onChange:function(c){c?f.push(e.slug):function(e,t){var c=e.indexOf(t);-1!==c&&e.splice(c,1)}(f,e.slug),h(f),p.bind(null,t,f)()}})}));return Object(o.createElement)("ul",null,m)}},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t){e.exports=function(e,t,c){return t in e?Object.defineProperty(e,t,{value:c,enumerable:!0,configurable:!0,writable:!0}):e[t]=c,e}},function(e,t,c){var r=c(10),l=c(11),n=c(12),a=c(14);e.exports=function(e,t){return r(e)||l(e,t)||n(e,t)||a()}},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){function c(){return e.exports=c=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var c=arguments[t];for(var r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r])}return e},c.apply(this,arguments)}e.exports=c},function(e,t,c){c(19),c(15),c(16),c(17),e.exports=c(18)},,function(e,t,c){},function(e,t){e.exports=function(e){if(Array.isArray(e))return e}},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var c=[],r=!0,l=!1,n=void 0;try{for(var a,o=e[Symbol.iterator]();!(r=(a=o.next()).done)&&(c.push(a.value),!t||c.length!==t);r=!0);}catch(e){l=!0,n=e}finally{try{r||null==o.return||o.return()}finally{if(l)throw n}}return c}}},function(e,t,c){var r=c(13);e.exports=function(e,t){if(e){if("string"==typeof e)return r(e,t);var c=Object.prototype.toString.call(e).slice(8,-1);return"Object"===c&&e.constructor&&(c=e.constructor.name),"Map"===c||"Set"===c?Array.from(e):"Arguments"===c||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(c)?r(e,t):void 0}}},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var c=0,r=new Array(t);c<t;c++)r[c]=e[c];return r}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(e,t,c){"use strict";c.r(t);var r=c(0),l=wp.i18n.__,n=wp.blocks.registerBlockType,a=wp.element.Fragment,o=wp.serverSideRender;n("vk-filter-search/keyword-search",{title:l("VK Keyword Search","vk-filter-search"),icon:Object(r.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(r.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(r.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(r.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(r.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],edit:function(){return Object(r.createElement)(a,null,Object(r.createElement)(o,{block:"vk-filter-search/keyword-search"}))}})},function(e,t,c){"use strict";c.r(t);var r=c(6),l=c.n(r),n=c(0),a=c(1),o=wp.i18n.__,i=wp.blocks.registerBlockType,s=wp.components,u=s.PanelBody,f=s.BaseControl,h=wp.element.Fragment,p=wp.blockEditor.InspectorControls,m=wp.serverSideRender;i("vk-filter-search/post-type-search",{title:o("VK Post Type Search","vk-filter-search"),icon:Object(n.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(n.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(n.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(n.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],attributes:{isCheckedPostType:{type:"string",default:'["post","page"]'}},edit:function(e){var t,c=e.attributes.isCheckedPostType,r=Object(a.b)().map((function(e){return{label:e.name,slug:e.slug}}));return t="[]"!==c?Object(n.createElement)(m,{block:"vk-filter-search/post-type-search",attributes:e.attributes}):Object(n.createElement)("div",{className:"vkfs_warning"},Object(n.createElement)("label",null,Object(n.createElement)("div",{className:"vkfs__label-name"},o("Post Type","vk-filter-search")),Object(n.createElement)("div",{className:"vkfs__warning-text"},o("Because no post type is selected, this block will not render.","vk-filter-search")))),Object(n.createElement)(h,null,Object(n.createElement)(p,null,Object(n.createElement)(u,{title:o("Post Type Option","vk-filter-search"),initialOpen:!0},Object(n.createElement)(f,{id:"vsfs02",label:o("Post Types","vk-filter-search")},Object(n.createElement)(a.a,l()({schema:"isCheckedPostType",rawData:r,checkedData:JSON.parse(c)},e))))),t)}})},function(e,t,c){"use strict";c.r(t);var r=c(0),l=c(1),n=wp.i18n,a=n.__,o=(n.sprintf,wp.blocks.registerBlockType),i=wp.components,s=i.PanelBody,u=i.BaseControl,f=i.SelectControl,h=wp.element.Fragment,p=wp.blockEditor.InspectorControls,m=wp.serverSideRender;o("vk-filter-search/taxonomy-search",{title:a("VK Taxonomy Search","vk-filter-search"),icon:Object(r.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(r.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(r.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(r.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(r.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],attributes:{isSelectedTaxonomy:{type:"string",default:"category"}},edit:function(e){var t=e.attributes,c=e.setAttributes,n=t.isSelectedTaxonomy,o=Object(l.c)(),i=Object(l.d)(o),v=o.map((function(e){return{label:e.name,slug:e.slug}})),b=[];Object.keys(i).forEach((function(e){var t;Array.isArray(i[e])&&i[e].length&&(t="tags"===e?v.filter((function(e){return"post_tag"===e.slug})):"categories"===e?v.filter((function(e){return"category"===e.slug})):v.filter((function(t){return t.slug===e})),b=b.concat(t))}));var d,y,k=b.map((function(e){return{label:e.label,value:e.slug}})),g=v.find((function(e){return e.slug===n}));return y=null!=g?g.label:"",d=b.some((function(e){return e.slug===n}))?Object(r.createElement)(m,{block:"vk-filter-search/taxonomy-search",attributes:e.attributes}):Object(r.createElement)("div",{className:"vkfs__warning"},Object(r.createElement)("label",null,Object(r.createElement)("div",{className:"vkfs__label-name"},y),Object(r.createElement)("div",{className:"vkfs__warning-text"},a("Because the taxonomy has no term, this block will not render.","vk-filter-search")))),Object(r.createElement)(h,null,Object(r.createElement)(p,null,Object(r.createElement)(s,{title:a("Taxonomy Option","vk-filter-search"),initialOpen:!0},Object(r.createElement)(u,{id:"vsfs03"},Object(r.createElement)(f,{label:a("Taxonomy","vk-filter-search"),value:n,options:k,onChange:function(e){return c({isSelectedTaxonomy:e})}})))),d)}})},function(e,t,c){"use strict";c.r(t);var r=c(0),l=wp.i18n.__,n=wp.blocks.registerBlockType,a=wp.element.Fragment,o=wp.components,i=o.PanelBody,s=o.BaseControl,u=o.SelectControl,f=wp.blockEditor.InspectorControls,h=wp.serverSideRender;n("vk-filter-search/call-search-form",{title:l("Call Search Form","vk-filter-search"),icon:Object(r.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(r.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(r.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(r.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(r.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",attributes:{TargetPost:{type:"number",default:-1}},edit:function(e){var t,c=e.attributes,n=e.setAttributes,o=c.TargetPost;return t=-1===o?Object(r.createElement)("p",null,l("Because no post is selected, The block Will not render","vk-filter-search")):Object(r.createElement)(h,{block:"vk-filter-search/call-search-form",attributes:e.attributes}),Object(r.createElement)(a,null,Object(r.createElement)(f,null,Object(r.createElement)(i,{title:l("Form Option","vk-filter-search"),initialOpen:!0},Object(r.createElement)(s,{id:"vsfs-call-01"},Object(r.createElement)(u,{label:l("Select Form","vk-filter-search"),value:o,options:vk_filter_search_posts,onChange:function(e){return n({TargetPost:parseInt(e,10)})}})))),t)}})},function(e,t,c){"use strict";c.r(t);var r=c(0),l=(c(8),c(9),c(1)),n=wp.blockEditor.InnerBlocks,a=wp.i18n.__,o={attributes:{TargetPostType:{type:"string",default:""}},save:function(e){var t,c=e.attributes.TargetPostType;return t=""===c?"":Object(r.createElement)("input",{type:"hidden",name:"post_type",value:c}),Object(r.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(r.createElement)("div",{className:"vkfs__labels"},t,Object(r.createElement)(n.Content,null)),"[no_keyword_hidden_input]",Object(r.createElement)("input",{className:"btn btn-primary",type:"submit",value:a("Refine search","vk-filter-search")}))}},i=wp.blockEditor.InnerBlocks,s=wp.i18n.__,u=[o,{attributes:{TargetPostType:{type:"string",default:""}},save:function(e){var t,c=e.attributes.TargetPostType,l=wp.data.select("core/editor").getCurrentPostId();return t=""===c?"":Object(r.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:c}),Object(r.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(r.createElement)("div",{className:"vkfs__labels"},t,Object(r.createElement)(i.Content,null)),"[no_keyword_hidden_input]",Object(r.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(r.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}),Object(r.createElement)("input",{className:"btn btn-primary",type:"submit",value:s("Refine search","vk-filter-search")}))}}],f=wp.i18n.__,h=wp.blocks.registerBlockType,p=wp.element.Fragment,m=wp.blockEditor.InnerBlocks,v=wp.blockEditor.InspectorControls,b=wp.components,d=b.PanelBody,y=b.BaseControl,k=b.SelectControl;h("vk-filter-search/filter-search",{title:f("VK Filter Search","vk-filter-search"),icon:Object(r.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(r.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(r.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(r.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(r.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",attributes:{TargetPostType:{type:"string",default:""}},example:{attributes:{TargetPostType:"post"},innerBlocks:[{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"category"}},{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"post_tag"}},{name:"vk-filter-search/keyword-search"}]},edit:function(e){var t,c,n=e.attributes,a=e.setAttributes,o=n.TargetPostType,i=Object(l.b)().map((function(e){return{label:e.name,value:e.slug}})),s=[{label:f("not specified","vk-blocks"),value:""}],u=0;if(null!=i)for(u=0;u<i.length;u++)s.push({label:i[u].label,value:i[u].value});return""===o?(t=["vk-filter-search/keyword-search","vk-filter-search/post-type-search","vk-filter-search/taxonomy-search"],c=""):(t=["vk-filter-search/keyword-search","vk-filter-search/taxonomy-search"],c=Object(r.createElement)("input",{type:"hidden",name:"post_type",value:o})),Object(r.createElement)(p,null,Object(r.createElement)(v,null,Object(r.createElement)(d,{title:f("Target of Post Type","vk-filter-search"),initialOpen:!0},Object(r.createElement)(y,{id:"vsfs-post-type01"},Object(r.createElement)(k,{label:f("Target of Post Type","vk-filter-search"),value:o,options:s,onChange:function(e){return a({TargetPostType:e})}})))),Object(r.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(r.createElement)("div",{className:"vkfs__labels"},c,Object(r.createElement)(m,{allowedBlocks:t,templateLock:!1,template:[["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"category"}],["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"post_tag"}],["vk-filter-search/keyword-search"]]})),Object(r.createElement)("input",{className:"btn btn-primary",type:"submit",value:f("Refine search","vk-filter-search")})))},save:function(e){var t,c=e.attributes.TargetPostType,l=wp.data.select("core/editor").getCurrentPostId();return t=""===c?"":Object(r.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:c}),Object(r.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(r.createElement)("div",{className:"vkfs__labels"},t,Object(r.createElement)(m.Content,null)),"[no_keyword_hidden_input]",Object(r.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(r.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:l}),Object(r.createElement)("input",{className:"btn btn-primary",type:"submit",value:f("Refine search","vk-filter-search")}))},deprecated:u})}]);