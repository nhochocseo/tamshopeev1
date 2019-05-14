function  select_change_order(parent, url){
    var ajaxurl = url;
    var data = {
      'action': 'POST',
      'page': 1,
      'orderby': parent
    };

    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;
    });
};

function  select_change_price(parent, url){
  var ajaxurl = url;
  var data = parent.split('-');
  var min_price = data[data.length - data.length];
  var max_price = data[data.length - 1];
  var data = {
    'action': 'POST',
    'page': 1,
    'min_price': min_price,
    'max_price': max_price
  };

  jQuery.post(ajaxurl, data, function(response) {
      document.getElementById("container-product").innerHTML = response;
  });
};
function  select_change_search(parent, url){
  console.log(parent);
  var ajaxurl = url;
  var data = {
    'action': 'POST',
    'page': 1,
    'keyseach': parent,
  };

  jQuery.post(ajaxurl, data, function(response) {
      document.getElementById("container-product").innerHTML = response;
  });
};