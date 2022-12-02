function coordinatesFromEvent(e) {
	return {
		x: e.clientX || e.touches[0].clientX,
		y: e.clientY || e.touches[0].clientY //we don't actually need the y coordinate, but we'll save it anyway just in case we'll ever decide to do something interesting with it
	}
}

$(document).ready(() => {
	$('.slider').each(function() {
		var slideSwitcherIntervalID = null,
				previousCursorPosition = null //no previous position means there's no dragging happening at the moment

		// Add a new bullet for each slide. Notice how we do this before cloning the first and last sides. If we were to do otherwise, we'd end up with 2 extra bullets.
		$(this).find('.slide').each((index) => {
			const bullet = $('<li class="bullet" />') 
			if(index == 0) bullet.addClass('active')

			$(this).find('.bullet-set').append(bullet)
		})
		
		const slideSet = $(this).find('.slide-set'),
					first = slideSet.children(':first-child').clone(),
			    last = slideSet.children(':last-child').clone()
			    
		//We add this class so that, in the future, we may know which slides are actually clones and which are the originals
		first.addClass('clone')
		last.addClass('clone')

		//Add the clones to the rest of the slides
		slideSet.append(first) //The clone of the first slide is added to the end
		slideSet.prepend(last) // The clone of the last slide is added to the beggining

		$(this).find('.slide').css('left', '-='+$(this).width()+'px') //Since we have added the clone of the last slide to the front, we must offset them to the left so that the first slide that is shown isn't the said clone, but the proper first slide that is technimally the second one now.

		const sliderPosition = (position, animate, callback) => {
			if(position == undefined)
				return Math.round(Math.abs($(this).find('.slide').position().left)/$(this).width()-1)
			if(animate == undefined) animate = true
			
			$(this)
				.find('.slide')
				.animate(
					{left: -(1+position)*$(this).width()+'px'},
					animate ? 1000 : 0
				)
				.promise().then(
				() => { // This gets executed right after the animation is done
					updateBullets()
					if(callback) callback()
				}
			)
		},
		isRunning = function() {
			return slideSwitcherIntervalID != null
		},
		switchSlides = () => {
			sliderPosition(
				sliderPosition() + 1,
				true,
				wrap
			)
		},
		startSlider = function() {
			//starting the loop and saving its ID into a variable We need the loop's ID so we can stop it when we will needed to
			slideSwitcherIntervalID = setInterval(
				switchSlides,
				7000 //switch slides every 7 seconds
			)
		},
		stopSlider = () => {
			clearInterval(slideSwitcherIntervalID)
			slideSwitcherIntervalID = null
		},
		wrap = () => {
			if(sliderPosition() >= $(this).find('.slide:not(.clone)').length)
				sliderPosition(0, false)
			else if (sliderPosition() < 0)
				sliderPosition($(this).find('.slide:not(.clone)').eq(-1).index()-1, false)
		},
		updateBullets = () => {
			const bullets = $(this).find('.bullet')

			bullets.removeClass('active')
			bullets.eq(sliderPosition()).addClass('active')
		},
		snap = function() {
			sliderPosition(
				sliderPosition(),
				true,
				wrap
			)
		},
		sliderIsWithinViewport = () => {
			return $(window).height() + $(document).scrollTop() >= $(this).offset().top && $(document).scrollTop() < $(this).offset().top + $(this).outerHeight(true)
		}

		var locked = false // we'll use this flag to lock the slider's controls during the sliding animation to avoid user input events queueing up

		$(this).find('.bullet').click(function() {
			if(locked) return

			if($(this).index() != sliderPosition()) {
				locked = true
				stopSlider()
				sliderPosition(
					$(this).index(),
					true,
					() => {
						startSlider()
						locked = false
					}
				)
			}
		})

		$(this).find('.control.left').click(() => {
			if(locked) return

			locked = true
			stopSlider() // Temporarily stop the slider so slides don't switch just as we click the button
			sliderPosition(
				sliderPosition() - 1,
				true,
				() => {
					wrap()
					startSlider() // Then start the slider again
					locked = false // Unlock slider controls when the sliding animation is done
				})
		})
		$(this).find('.control.right').click(() => {
			if(locked) return

			locked = true
			stopSlider() // Temporarily stop the slider so slides don't switch just as we click the button
			sliderPosition(
				sliderPosition() + 1,
				true,
				() => {
					wrap()
					startSlider() // Then start the slider again
					locked = false
				})
		})

		$(document).scroll((e) => {
			if(isRunning() && !sliderIsWithinViewport())
				stopSlider()
			else if(!isRunning() && sliderIsWithinViewport())
				startSlider()
		})

		startSlider()
	})

})

