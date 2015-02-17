(($) ->

  doc = $ document

  # Show Menu

  toggle = $ '.head-toggle'
  isVisible = false

  toggleOff = (e) ->
    toggle.trigger 'click.rj' if !$(e.target).closest('.head-navigation').length

  toggle.on 'click.rj', (e) ->
    do e.preventDefault
    if isVisible
      $('.head-nav').removeClass 'active'
      doc.off 'click.rj'
    else
      $('.head-nav').addClass 'active'
      doc.on 'click.rj', toggleOff
    isVisible = !isVisible
    return

  # Tabs

  $ '.nav-tabs'
    .on 'click.rj', 'a', (e) ->
      do e.preventDefault
      $ @hash
        .show()
        .siblings()
        .hide()
      $ this
        .parent()
        .addClass 'active'
        .siblings()
        .removeClass 'active'
    .find 'a:first'
    .trigger 'click.rj'

  # Fancybox

  $ '.fancy,a[href$=".gif"],a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"]'
    .fancybox()
  $ '.gallery-view'
    .off 'click'
    .on 'click', (e) ->
      do e.preventDefault
      $ this
        .next()
        .trigger 'click'

  # Gallery

  thumbs = $ '.gallery-thumb'
  if thumbs.length > 4
    showThumbs = ->
      thumbs
        .hide()
        .slice current, current + 4
        .show()
    current = 0
    total = thumbs.length - 4
    thumbs
      .last()
      .after '<button id="gallery-prev">‹</button><button id="gallery-next">›</button>'
    $ '#gallery-prev'
      .on 'click', (e) ->
        do e.preventDefault
        current-- if current > 0
        do showThumbs
    $ '#gallery-next'
      .on 'click', (e) ->
        do e.preventDefault
        current++ if current < total
        do showThumbs

  return
) jQuery
