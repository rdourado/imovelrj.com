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

  return

) jQuery