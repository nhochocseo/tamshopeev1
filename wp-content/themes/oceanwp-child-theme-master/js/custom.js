function  select_change_order(parent, url, page){
    var ajaxurl = url;
    var data = {
      'action': 'POST',
      'paged': page,
      'orderby': parent
    };

    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;
    });
};
function  load_all_data(url, page){
  alert(url);
  var ajaxurl = url;
  var data = {
    'action': 'POST',
    'paged': page,
  };

  jQuery.post(ajaxurl, data, function(response) {
      document.getElementById("container-product").innerHTML = response;
  });
};
function  select_change_price(parent, url, page){
  var ajaxurl = url;
  var data = parent.split('-');
  var min_price = data[data.length - data.length];
  var max_price = data[data.length - 1];
  var data = {
    'action': 'POST',
    'paged': page,
    'min_price': min_price,
    'max_price': max_price
  };

  jQuery.post(ajaxurl, data, function(response) {
      document.getElementById("container-product").innerHTML = response;
  });
};
function  select_change_search(parent, url, page){
  var ajaxurl = url;
  var data = {
    'action': 'POST',
    'paged': page,
    'keyseach': parent,
  };

  jQuery.post(ajaxurl, data, function(response) {
      document.getElementById("container-product").innerHTML = response;
  });
};