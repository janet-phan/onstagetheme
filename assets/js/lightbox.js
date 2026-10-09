/**
 * On Stage Lightbox Gallery Script
 * Full-screen image lightbox modal with instant keyboard focus (←/→), mouse wheel/trackpad scroll,
 * touch swipe, click to advance, and ESC to close.
 */
document.addEventListener('DOMContentLoaded', function () {
	// Create modal HTML structure once
	var modal = document.createElement('div');
	modal.className = 'onstage-lightbox-modal';
	modal.setAttribute('role', 'dialog');
	modal.setAttribute('aria-modal', 'true');
	modal.setAttribute('aria-label', 'Image Lightbox');
	modal.setAttribute('tabindex', '-1');
	modal.innerHTML = `
		<div class="onstage-lightbox-overlay"></div>
		<div class="onstage-lightbox-content">
			<button type="button" class="onstage-lightbox-close" aria-label="Close lightbox">&times;</button>
			<button type="button" class="onstage-lightbox-prev" aria-label="Previous image">&#10094;</button>
			<button type="button" class="onstage-lightbox-next" aria-label="Next image">&#10095;</button>
			<div class="onstage-lightbox-stage">
				<img class="onstage-lightbox-image" src="" alt="" />
			</div>
			<div class="onstage-lightbox-meta">
				<div class="onstage-lightbox-counter"></div>
				<div class="onstage-lightbox-caption"></div>
			</div>
		</div>
	`;
	document.body.appendChild(modal);

	var imgElement = modal.querySelector('.onstage-lightbox-image');
	var counterElement = modal.querySelector('.onstage-lightbox-counter');
	var captionElement = modal.querySelector('.onstage-lightbox-caption');
	var closeBtn = modal.querySelector('.onstage-lightbox-close');
	var prevBtn = modal.querySelector('.onstage-lightbox-prev');
	var nextBtn = modal.querySelector('.onstage-lightbox-next');
	var overlay = modal.querySelector('.onstage-lightbox-overlay');

	var currentGallery = [];
	var currentIndex = 0;
	var touchStartX = 0;
	var touchEndX = 0;
	var wheelTimer = null;

	function openLightbox(galleryImages, index) {
		if (!galleryImages || !galleryImages.length) return;
		currentGallery = galleryImages;
		currentIndex = index;
		updateLightbox();
		modal.classList.add('is-active');
		document.documentElement.style.overflow = 'hidden';
		document.body.style.overflow = 'hidden';

		// Focus modal immediately so keyboard arrows work on the very first keypress
		setTimeout(function () {
			modal.focus();
		}, 10);
	}

	function closeLightbox() {
		modal.classList.remove('is-active');
		document.documentElement.style.overflow = '';
		document.body.style.overflow = '';
		imgElement.src = '';
	}

	function updateLightbox() {
		if (!currentGallery.length) return;
		var item = currentGallery[currentIndex];
		imgElement.src = item.src;
		imgElement.alt = item.alt || '';
		counterElement.textContent = (currentIndex + 1) + ' / ' + currentGallery.length;
		captionElement.textContent = item.caption || item.alt || '';

		if (currentGallery.length > 1) {
			prevBtn.style.display = 'flex';
			nextBtn.style.display = 'flex';
		} else {
			prevBtn.style.display = 'none';
			nextBtn.style.display = 'none';
		}
	}

	function showNext() {
		if (!currentGallery.length) return;
		currentIndex = (currentIndex + 1) % currentGallery.length;
		updateLightbox();
	}

	function showPrev() {
		if (!currentGallery.length) return;
		currentIndex = (currentIndex - 1 + currentGallery.length) % currentGallery.length;
		updateLightbox();
	}

	// Keyboard navigation & ESC close (bound to window & document for immediate capture)
	function handleKeyDown(e) {
		if (!modal.classList.contains('is-active')) return;
		var key = e.key || e.code;
		if (key === 'Escape' || e.keyCode === 27) {
			e.preventDefault();
			closeLightbox();
		} else if (key === 'ArrowRight' || e.keyCode === 39) {
			e.preventDefault();
			showNext();
		} else if (key === 'ArrowLeft' || e.keyCode === 37) {
			e.preventDefault();
			showPrev();
		}
	}

	window.addEventListener('keydown', handleKeyDown, true);
	document.addEventListener('keydown', handleKeyDown, true);

	// Mouse wheel & Trackpad scroll navigation between gallery photos
	modal.addEventListener('wheel', function (e) {
		if (!modal.classList.contains('is-active')) return;
		e.preventDefault();
		if (wheelTimer) return;

		if (e.deltaY > 10 || e.deltaX > 10) {
			showNext();
		} else if (e.deltaY < -10 || e.deltaX < -10) {
			showPrev();
		}

		wheelTimer = setTimeout(function () {
			wheelTimer = null;
		}, 250);
	}, { passive: false });

	// Prevent background page touch scroll when modal is open
	modal.addEventListener('touchmove', function (e) {
		if (modal.classList.contains('is-active')) {
			e.preventDefault();
		}
	}, { passive: false });

	// Click image to advance to next photo
	imgElement.addEventListener('click', function (e) {
		e.stopPropagation();
		if (currentGallery.length > 1) {
			showNext();
		}
	});

	// Click event handlers
	closeBtn.addEventListener('click', closeLightbox);
	overlay.addEventListener('click', closeLightbox);
	nextBtn.addEventListener('click', function (e) {
		e.stopPropagation();
		showNext();
	});
	prevBtn.addEventListener('click', function (e) {
		e.stopPropagation();
		showPrev();
	});

	// Mobile touch swipe
	imgElement.addEventListener('touchstart', function (e) {
		touchStartX = e.changedTouches[0].screenX;
	}, { passive: true });

	imgElement.addEventListener('touchend', function (e) {
		touchEndX = e.changedTouches[0].screenX;
		if (touchStartX - touchEndX > 40) {
			showNext();
		} else if (touchEndX - touchStartX > 40) {
			showPrev();
		}
	}, { passive: true });

	// Initialize all galleries on page
	function initGalleries() {
		var gallerySelectors = [
			'.wp-block-gallery',
			'.gallery-grid',
			'.costume-gallery-grid',
			'.past-productions-gallery',
			'.past-productions-grid',
			'.destination-gallery-grid',
			'.show-gallery-grid',
			'.behind-scenes'
		];

		var containers = document.querySelectorAll(gallerySelectors.join(', '));

		containers.forEach(function (container) {
			var imgNodes = container.querySelectorAll('img');
			if (!imgNodes.length) return;

			var galleryItems = [];
			imgNodes.forEach(function (img) {
				var src = img.currentSrc || img.src;
				var parentAnchor = img.closest('a');
				if (parentAnchor && /\.(jpg|jpeg|png|gif|webp)$/i.test(parentAnchor.href)) {
					src = parentAnchor.href;
				}

				var figcaption = img.closest('figure') ? img.closest('figure').querySelector('figcaption') : null;
				var captionText = figcaption ? figcaption.textContent.trim() : '';

				galleryItems.push({
					src: src,
					alt: img.alt || '',
					caption: captionText
				});
			});

			imgNodes.forEach(function (img, idx) {
				if (img.dataset.lightboxBound) return;
				img.dataset.lightboxBound = 'true';
				img.style.cursor = 'pointer';

				var parentAnchor = img.closest('a');
				var target = parentAnchor || img;

				target.addEventListener('click', function (e) {
					e.preventDefault();
					openLightbox(galleryItems, idx);
				});
			});
		});

		// Standalone images (not inside a gallery block)
		var standaloneImages = document.querySelectorAll('.wp-block-image img:not([data-lightbox-bound])');
		standaloneImages.forEach(function (img) {
			if (img.classList.contains('staff-img') || img.closest('.staff-img-col') || img.closest('.staff-member') || img.closest('.wp-block-gallery') || img.closest('.behind-scenes') || img.closest('.gallery-grid') || img.classList.contains('no-lightbox')) {
				img.dataset.lightboxBound = 'true';
				return;
			}
			img.dataset.lightboxBound = 'true';
			img.style.cursor = 'pointer';

			var src = img.currentSrc || img.src;
			var parentAnchor = img.closest('a');
			if (parentAnchor && /\.(jpg|jpeg|png|gif|webp)$/i.test(parentAnchor.href)) {
				src = parentAnchor.href;
			}

			var figcaption = img.closest('figure') ? img.closest('figure').querySelector('figcaption') : null;
			var captionText = figcaption ? figcaption.textContent.trim() : '';

			var singleItem = [{
				src: src,
				alt: img.alt || '',
				caption: captionText
			}];

			var target = parentAnchor || img;
			target.addEventListener('click', function (e) {
				e.preventDefault();
				openLightbox(singleItem, 0);
			});
		});
	}

	initGalleries();
});
