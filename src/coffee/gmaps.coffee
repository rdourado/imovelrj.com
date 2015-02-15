### global google ###

(($) ->

  render_map = ($el) ->
    $markers = $el.find('.marker')
    args = {
      zoom: 16
      center: new (google.maps.LatLng)(0, 0)
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new (google.maps.Map)($el[0], args)
    map.markers = []
    $markers.each ->
      add_marker $(this), map
      return
    center_map map
    return

  add_marker = ($marker, map) ->
    latlng = new (google.maps.LatLng)($marker.attr('data-lat'), $marker.attr('data-lng'))
    marker = new (google.maps.Marker)({
      position: latlng
      map: map
    })
    map.markers.push marker
    if $marker.html()
      infowindow = new (google.maps.InfoWindow)({content: $marker.html()})
      google.maps.event.addListener marker, 'click', ->
        infowindow.open map, marker
        return
    return

  center_map = (map) ->
    bounds = new (google.maps.LatLngBounds)()
    $.each map.markers, (i, marker) ->
      latlng = new (google.maps.LatLng)(marker.position.lat(), marker.position.lng())
      bounds.extend latlng
      return
    if map.markers.length == 1
      map.setCenter bounds.getCenter()
      map.setZoom 16
    else
      map.fitBounds bounds
    return

  $(document).ready ->
    $('.acf-map').each ->
      render_map $(this)
      return
    return

  return
) jQuery
