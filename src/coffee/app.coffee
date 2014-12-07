(($) ->

  doc = $ document
  toggle = $ '.head-toggle'
  isVisible = false

  toggleOff = (e) ->
    toggle.trigger 'click' if !$(e.target).closest('.head-navigation').length

  toggle.on 'click', (e) ->
    do e.preventDefault
    if isVisible
      $('.head-nav').removeClass 'active'
      doc.off 'click.rj'
    else
      $('.head-nav').addClass 'active'
      doc.on 'click.rj', toggleOff
    isVisible = !isVisible

  return

) jQuery