(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{5:function(e,t,c){}}]),function(e){function t(t){for(var l,a,s=t[0],i=t[1],o=t[2],p=0,m=[];p<s.length;p++)a=s[p],Object.prototype.hasOwnProperty.call(r,a)&&r[a]&&m.push(r[a][0]),r[a]=0;for(l in i)Object.prototype.hasOwnProperty.call(i,l)&&(e[l]=i[l]);for(u&&u(t);m.length;)m.shift()();return n.push.apply(n,o||[]),c()}function c(){for(var e,t=0;t<n.length;t++){for(var c=n[t],l=!0,s=1;s<c.length;s++){var i=c[s];0!==r[i]&&(l=!1)}l&&(n.splice(t--,1),e=a(a.s=c[0]))}return e}var l={},r={0:0},n=[];function a(t){if(l[t])return l[t].exports;var c=l[t]={i:t,l:!1,exports:{}};return e[t].call(c.exports,c,c.exports,a),c.l=!0,c.exports}a.m=e,a.c=l,a.d=function(e,t,c){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:c})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var c=Object.create(null);if(a.r(c),Object.defineProperty(c,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var l in e)a.d(c,l,function(t){return e[t]}.bind(null,l));return c},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="";var s=window.webpackJsonp=window.webpackJsonp||[],i=s.push.bind(s);s.push=t,s=s.slice();for(var o=0;o<s.length;o++)t(s[o]);var u=i;n.push([12,1]),c()}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){function c(){return e.exports=c=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var c=arguments[t];for(var l in c)Object.prototype.hasOwnProperty.call(c,l)&&(e[l]=c[l])}return e},c.apply(this,arguments)}e.exports=c},function(e,t){e.exports=function(e,t,c){return t in e?Object.defineProperty(e,t,{value:c,enumerable:!0,configurable:!0,writable:!0}):e[t]=c,e}},function(e,t,c){var l=c(7),r=c(8),n=c(9),a=c(11);e.exports=function(e,t){return l(e)||r(e,t)||n(e,t)||a()}},function(e,t){!function(){e.exports=this.wp.components}()},,function(e,t,c){},function(e,t){e.exports=function(e){if(Array.isArray(e))return e}},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var c=[],l=!0,r=!1,n=void 0;try{for(var a,s=e[Symbol.iterator]();!(l=(a=s.next()).done)&&(c.push(a.value),!t||c.length!==t);l=!0);}catch(e){r=!0,n=e}finally{try{l||null==s.return||s.return()}finally{if(r)throw n}}return c}}},function(e,t,c){var l=c(10);e.exports=function(e,t){if(e){if("string"==typeof e)return l(e,t);var c=Object.prototype.toString.call(e).slice(8,-1);return"Object"===c&&e.constructor&&(c=e.constructor.name),"Map"===c||"Set"===c?Array.from(e):"Arguments"===c||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(c)?l(e,t):void 0}}},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var c=0,l=new Array(t);c<t;c++)l[c]=e[c];return l}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(e,t,c){"use strict";c.r(t);var l=c(1),r=c.n(l),n=c(0),a=(c(5),c(6),wp.blockEditor.InnerBlocks),s=wp.i18n.__,i={attributes:{TargetPostType:{type:"string",default:""}},save:function(e){var t,c=e.attributes.TargetPostType;return t=""===c?"":Object(n.createElement)("input",{type:"hidden",name:"post_type",value:c}),Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},t,Object(n.createElement)(a.Content,null)),"[no_keyword_hidden_input]",Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:s("Refine search","vk-filter-search")}))}},o=wp.blockEditor.InnerBlocks,u=wp.i18n.__,p={attributes:{TargetPostType:{type:"string",default:""}},save:function(e){var t,c=e.attributes.TargetPostType;return t=""===c?"":Object(n.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:c}),Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},t,Object(n.createElement)(o.Content,null)),"[no_keyword_hidden_input]",Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:u("Refine search","vk-filter-search")}))}},m=wp.blockEditor.InnerBlocks,h=wp.i18n.__,f={attributes:{TargetPostType:{type:"string",default:""},DisplayOnResult:{type:"boolean",default:!1}},save:function(e){var t,c,l=e.attributes,r=l.TargetPostType,a=l.DisplayOnResult,s=wp.data.select("core/editor").getCurrentPostId();return t=""===r?"":Object(n.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:r}),c=a?Object(n.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:s}):"",Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},t,Object(n.createElement)(m.Content,null)),"[no_keyword_hidden_input]",Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),c,Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:h("Refine search","vk-filter-search")}))}},v=wp.blockEditor.InnerBlocks,b=wp.i18n.__,d={attributes:{TargetPostType:{type:"string",default:""},DisplayOnResult:{type:"boolean",default:!1}},save:function(e){var t,c,l=e.attributes,r=l.TargetPostType,a=l.DisplayOnResult,s=wp.data.select("core/editor").getCurrentPostId();return t=""===r?"":Object(n.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:r}),c=a?Object(n.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:s}):"",Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},t,Object(n.createElement)(v.Content,null)),"[no_keyword_hidden_input]",Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),c,Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:b("Search","vk-filter-search")}))}},y=wp.blockEditor.InnerBlocks,k=wp.i18n.__,_=[i,p,f,d,{attributes:{TargetPostType:{type:"string",default:""},DisplayOnResult:{type:"boolean",default:!1},PostID:{type:"number",default:null}},save:function(e){var t,c,l=e.attributes,r=l.TargetPostType,a=l.DisplayOnResult,s=l.PostID;return t=""===r?"":Object(n.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:r}),c=a?Object(n.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:s}):"",Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},Object(n.createElement)(y.Content,null)),"[no_keyword_hidden_input]",t,c,Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:k("Search","vk-filter-search")}))}}],O=c(2),j=c.n(O),E=c(3),g=c.n(E),w=c(4),T=function(e){var t=e.schema,c=e.rawData,l=e.checkedData,r=e.setAttributes,a=Object(n.useState)(l),s=g()(a,2),i=s[0],o=s[1];if(!c||!l)return!1;var u=function(e,t){r(j()({},e,JSON.stringify(t)))},p=c.map((function(e){return Object(n.createElement)(w.CheckboxControl,{key:e.slug,label:e.label,checked:i.some((function(t){return t===e.slug})),onChange:function(c){c?i.push(e.slug):function(e,t){var c=e.indexOf(t);-1!==c&&e.splice(c,1)}(i,e.slug),o(i),u.bind(null,t,i)()}})}));return Object(n.createElement)("ul",null,p)},x=wp.i18n.__,P=wp.blocks.registerBlockType,S=wp.element.Fragment,D=wp.blockEditor.InnerBlocks,N=wp.blockEditor.InspectorControls,z=wp.components,C=z.PanelBody,R=z.BaseControl,B=z.SelectControl,I=z.ToggleControl;P("vk-filter-search/filter-search",{title:x("VK Filter Search","vk-filter-search"),icon:Object(n.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(n.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(n.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(n.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",attributes:{TargetPostType:{type:"string",default:""},DisplayOnResult:{type:"boolean",default:!1},DisplayOnArchive:{type:"string",default:"[]"},FormID:{type:"string",default:null}},example:{attributes:{TargetPostType:"post",DisplayOnResult:!1,DisplayOnArchive:"[]",FormID:null},innerBlocks:[{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"category"}},{name:"vk-filter-search/taxonomy-search",attributes:{isSelectedTaxonomy:"post_tag"}},{name:"vk-filter-search/keyword-search"}]},edit:function(e){var t,c,l,a=e.attributes,s=e.setAttributes,i=a.TargetPostType,o=a.DisplayOnResult,u=a.DisplayOnArchive,p=a.FormID;return null==p&&s({FormID:vkfs_form_id}),""===i?(t=["vk-filter-search/keyword-search","vk-filter-search/post-type-search","vk-filter-search/taxonomy-search"],c=""):(t=["vk-filter-search/keyword-search","vk-filter-search/taxonomy-search"],c=Object(n.createElement)("input",{type:"hidden",name:"post_type",value:i})),l=o?Object(n.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:p}):"",Object(n.createElement)(S,null,Object(n.createElement)(N,null,Object(n.createElement)(C,{title:x("Target of Post Type","vk-filter-search"),initialOpen:!0},Object(n.createElement)(R,{id:"vkfs-search-form-01"},Object(n.createElement)(B,{label:x("Target of Post Type","vk-filter-search"),value:i,options:vk_filter_search_post_type_select,onChange:function(e){return s({TargetPostType:e})}})),Object(n.createElement)(R,{id:"vkfs-search-form-02"},Object(n.createElement)(I,{label:"Display this form on search result page",checked:o,onChange:function(e){return s({DisplayOnResult:e})}})),Object(n.createElement)(R,{id:"vkfs-search-form-03",label:x("Display this form on post type archive page.","vk-filter-search")},Object(n.createElement)(T,r()({schema:"DisplayOnArchive",rawData:vk_filter_search_post_type_checkbox,checkedData:JSON.parse(u)},e))))),Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},Object(n.createElement)(D,{allowedBlocks:t,templateLock:!1,template:[["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"category"}],["vk-filter-search/taxonomy-search",{isSelectedTaxonomy:"post_tag"}],["vk-filter-search/keyword-search"]]})),c,l,Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:x("Search","vk-filter-search")})))},save:function(e){var t,c,l=e.attributes,r=l.TargetPostType,a=l.DisplayOnResult,s=l.FormID;return t=""===r?"":Object(n.createElement)("input",{type:"hidden",name:"vkfs_post_type[]",value:r}),c=a?Object(n.createElement)("input",{type:"hidden",name:"vkfs_form_id",value:s}):"",Object(n.createElement)("form",{className:"vk-filter-search vkfs",method:"get",action:vk_filter_search_url},Object(n.createElement)("div",{className:"vkfs__labels"},Object(n.createElement)(D.Content,null)),"[no_keyword_hidden_input]",t,c,Object(n.createElement)("input",{type:"hidden",name:"vkfs_submitted",value:"true"}),Object(n.createElement)("input",{className:"btn btn-primary",type:"submit",value:x("Search","vk-filter-search")}))},deprecated:_});var A=wp.i18n.__,F=wp.blocks.registerBlockType,J=wp.element.Fragment,K=wp.serverSideRender;F("vk-filter-search/keyword-search",{title:A("VK Keyword Search","vk-filter-search"),icon:Object(n.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(n.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(n.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(n.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],edit:function(){return Object(n.createElement)(J,null,Object(n.createElement)(K,{block:"vk-filter-search/keyword-search"}))}});var M=wp.i18n.__,V=wp.blocks.registerBlockType,L=wp.components,U=L.PanelBody,$=L.BaseControl,q=wp.element.Fragment,G=wp.blockEditor.InspectorControls,H=wp.serverSideRender;V("vk-filter-search/post-type-search",{title:M("VK Post Type Search","vk-filter-search"),icon:Object(n.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(n.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(n.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(n.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],attributes:{isCheckedPostType:{type:"string",default:'["post","page"]'}},edit:function(e){var t,c=e.attributes.isCheckedPostType;return t="[]"!==c?Object(n.createElement)(H,{block:"vk-filter-search/post-type-search",attributes:e.attributes}):Object(n.createElement)("div",{className:"vkfs_warning"},Object(n.createElement)("label",null,Object(n.createElement)("div",{className:"vkfs__label-name"},M("Post Type","vk-filter-search")),Object(n.createElement)("div",{className:"vkfs__warning-text"},M("Because no post type is selected, this block will not render.","vk-filter-search")))),Object(n.createElement)(q,null,Object(n.createElement)(G,null,Object(n.createElement)(U,{title:M("Post Type Option","vk-filter-search"),initialOpen:!0},Object(n.createElement)($,{id:"vsfs02",label:M("Post Types","vk-filter-search")},Object(n.createElement)(T,r()({schema:"isCheckedPostType",rawData:vk_filter_search_post_type_checkbox,checkedData:JSON.parse(c)},e))))),t)}});var Q=wp.i18n,W=Q.__,X=(Q.sprintf,wp.blocks.registerBlockType),Y=wp.components,Z=Y.PanelBody,ee=Y.BaseControl,te=Y.SelectControl,ce=wp.element.Fragment,le=wp.blockEditor.InspectorControls,re=wp.serverSideRender;X("vk-filter-search/taxonomy-search",{title:W("VK Taxonomy Search","vk-filter-search"),icon:Object(n.createElement)("svg",{height:"25",viewBox:"0 0 24 25",width:"24",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z",fill:"#000"}),Object(n.createElement)("path",{clipRule:"evenodd",d:"m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z",fill:"#fff",fillRule:"evenodd"}),Object(n.createElement)("path",{d:"m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z",fill:"#000"}),Object(n.createElement)("path",{d:"m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z",fill:"#d8141c"})),category:"vk-blocks-cat",parent:["vk-filter-search/filter-search"],attributes:{isSelectedTaxonomy:{type:"string",default:"category"}},edit:function(e){var t,c=e.attributes,l=e.setAttributes,r=c.isSelectedTaxonomy,a=vk_filter_search_taxonomy_list.find((function(e){return e.value===r}));return t=vk_filter_search_taxonomy_option.some((function(e){return e.value===r}))?Object(n.createElement)(re,{block:"vk-filter-search/taxonomy-search",attributes:e.attributes}):Object(n.createElement)("div",{className:"vkfs__warning"},Object(n.createElement)("label",null,Object(n.createElement)("div",{className:"vkfs__label-name"},a.label),Object(n.createElement)("div",{className:"vkfs__warning-text"},W("Because the taxonomy has no term, this block will not render.","vk-filter-search")))),Object(n.createElement)(ce,null,Object(n.createElement)(le,null,Object(n.createElement)(Z,{title:W("Taxonomy Option","vk-filter-search"),initialOpen:!0},Object(n.createElement)(ee,{id:"vsfs03"},Object(n.createElement)(te,{label:W("Taxonomy","vk-filter-search"),value:r,options:vk_filter_search_taxonomy_option,onChange:function(e){return l({isSelectedTaxonomy:e})}})))),t)}})}]);