
function get_url_queries(){const query_string=window.location.search.slice(1);let queries={};if(!query_string){return queries;}
query_string.split('&').forEach(function(query_string){const query_array=query_string.split('=');queries[query_array[0]]=query_array[1];});return queries;}
const form_html=document.getElementsByClassName('vk-filter-search');const url_queries=get_url_queries();const set_query_value=(i)=>{Object.keys(url_queries).forEach(key=>{if(key==='s'){const keyword_selector=form_html[i].querySelector('.vkfs__keyword input[name="s"]');if(keyword_selector!==null){keyword_selector.value=url_queries[key];}}
else if(key==='post_type'){const post_type_select_selector=form_html[i].querySelector('.vkfs__post-type select[name="vkfs_post_type[]"]');if(post_type_select_selector!==null){post_type_select_selector.value=url_queries[key];}}
else if(key==='category_name'){const category_select_selector=form_html[i].querySelector('.vkfs__taxonomy select[name="vkfs_category[]"]');if(category_select_selector!==null){category_select_selector.value=url_queries[key];}}
else if(key==='tag'){const tag_select_selector=form_html[i].querySelector('.vkfs__taxonomy select[name="vkfs_post_tag[]"]');if(tag_select_selector!==null){tag_select_selector.value=url_queries[key];}}
console.log('key:'+key+' value:'+url_queries[key]);});}
for(let i=0;i<form_html.length;i++){set_query_value(i);}