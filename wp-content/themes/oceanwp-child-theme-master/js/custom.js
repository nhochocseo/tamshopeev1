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
  console.log(data);
  var min_price = data[data.length - data.length]
  var max_price = data[data.length - 1]
  console.log(min_price);
  var data = {
    'action': 'POST',
    'page': 1,
    'min_price': min_price,
    'max_price': max_price
  };

  jQuery.post(ajaxurl, data, function(response) {
      // $('.container-product').innerHTML(response);
      document.getElementById("container-product").innerHTML = response;
  });
};