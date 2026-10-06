/**
 * On Stage Lightbox Gallery Script
 * Full-screen image lightbox modal with keyboard arrows (←/→), ESC to close, and touch swipe.
 */
document.addEventListener('DOMContentLoaded', function () {
	// Create modal HTML structure once
	var modal = document.createElement('div');
	modal.className = 'onstage-lightbox-modal';
	modal.setAttribute('role', 'dialog');
	modal.setAttribute('aria-modal', 'true');
	modal.setAttribute('aria-label', 'Image Lightbox');
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

	function openLightbox(galleryImages, index) {
		if (!galleryImages || !galleryImages.length) return;
		currentGallery = galleryImages;
		currentIndex = index;
		updateLightbox();
		modal.classList.add('is-active');
		document.body.style.overflow = 'hidden';
	}

	function closeLightbox() {
		modal.classList.remove('is-active');
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

	// Keyboard navigation & ESC close
	document.addEventListener('keydown', function (e) {
		if (!modal.classList.contains('is-active')) return;
		if (e.key === 'Escape' || e.keyCode === 27) {
			closeLightbox();
		} else if (e.key === 'ArrowRight' || e.keyCode === 39) {
			showNext();
		} else if (e.key === 'ArrowLeft' || e.keyCode === 37) {
			showPrev();
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
