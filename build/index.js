!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=11)}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){function n(){return e.exports=n=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e},n.apply(this,arguments)}e.exports=n},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}},function(e,t,n){var r=n(6),o=n(7),c=n(8),a=n(10);e.exports=function(e,t){return r(e)||o(e,t)||c(e,t)||a()}},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){e.exports=function(e){if(Array.isArray(e))return e}},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}}},function(e,t,n){var r=n(9);e.exports=function(e,t){if(e){if("string"==typeof e)return r(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?r(e,t):void 0}}},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(e,t,n){"use strict";n.r(t);var r=n(1),o=n.n(r),c=n(0),a=n(3),i=n.n(a),l=n(4),u=n.n(l),s=n(2),f=n(5),p=function(e){var t=e.schema,n=e.rawData,r=e.checkedData,o=e.setAttributes;if(!n||!r)return!1;var a=Object(c.useState)(r),l=u()(a,2),s=l[0],p=l[1],b=function(e,t){o(i()({},e,JSON.stringify(t)))},y=n.map((function(e){return Object(c.createElement)(f.CheckboxControl,{key:e.slug,label:e.label,checked:s.some((function(t){return t===e.slug})),onChange:function(n){n?s.push(e.slug):function(e,t){var n=e.indexOf(t);-1!==n&&e.splice(n,1)}(s,e.slug),p(s),b.bind(null,t,s)()}})}));return Object(c.createElement)("ul",null,y)},b=wp.i18n.__,y=wp.blocks.registerBlockType,d=wp.components,m=d.PanelBody,h=d.BaseControl,g=d.CheckboxControl,v=wp.element.Fragment,O=wp.blockEditor.InspectorControls,j=wp.serverSideRender;y("vk-filter-search/filter-search",{title:"VK Filter Search",icon:"search",category:"widgets",attributes:{showKeyword:{type:"boolean",default:!0},isCheckedPostType:{type:"string",default:'["post","page"]'},isCheckedTaxonomy:{type:"string",default:'["category","post_tag"]'}},edit:function(e){var t=e.attributes,n=e.setAttributes,r=e.name,a=t.showKeyword,i=t.isCheckedPostType,l=t.isCheckedTaxonomy;t.name=r;var u=Object(s.useSelect)((function(e){return e("core").getPostTypes({per_page:-1})||[]}),[]).map((function(e){return{label:e.name,slug:e.slug}})),f=Object(s.useSelect)((function(e){return e("core").getTaxonomies({per_page:-1})||[]}),[]).map((function(e){return{label:e.name,slug:e.slug}}));return Object(c.createElement)(v,null,Object(c.createElement)(O,null,Object(c.createElement)(m,{title:b("Display conditions","vk-blocks"),initialOpen:!1},Object(c.createElement)(h,{label:b("Filter by Keyword","vk-blocks")},Object(c.createElement)(g,{className:"mb-1",checked:a,onChange:function(e){return n({showKeyword:e})}})),Object(c.createElement)(h,{label:b("Filter by PostTypes","vk-blocks")},Object(c.createElement)(p,o()({schema:"isCheckedPostType",rawData:u,checkedData:JSON.parse(i)},e))),Object(c.createElement)(h,{label:b("Filter by Taxonomies","vk-blocks")},Object(c.createElement)(p,o()({schema:"isCheckedTaxonomy",rawData:f,checkedData:JSON.parse(l)},e))))),Object(c.createElement)(j,{block:"vk-filter-search/filter-search",attributes:e.attributes}))}})}]);