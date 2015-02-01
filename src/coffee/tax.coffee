### global myAjax ###
(($) ->

  $.ajax {
    type: 'post'
    dataType: 'json'
    url: myAjax.ajaxurl
    data: {
      action: 'my_tax_count'
      tax_id: myAjax.tax_id
      tax_type: myAjax.tax_type
      nonce: myAjax.nonce
    }
  }

  return

) jQuery