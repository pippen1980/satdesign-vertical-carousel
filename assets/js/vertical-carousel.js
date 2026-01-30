(function($) {
    'use strict';

    class VerticalCarousel {
        constructor(element) {
            this.$container = $(element);
            this.$track = this.$container.find('.mvc-carousel-track');
            this.$items = this.$track.find('.mvc-carousel-item');

            if (this.$items.length === 0) return;

            this.speed = parseFloat(this.$container.data('speed')) || 30;
            this.direction = this.$container.data('direction') || 'up';
            this.pauseOnHover = this.$container.data('pause-hover') === true || this.$container.data('pause-hover') === 'true';

            this.isPaused = false;
            this.position = 0;
            this.lastTime = null;
            this.animationId = null;
            this.trackHeight = 0;

            this.init();
        }

        init() {
            this.waitForImages().then(() => {
                this.setupClones();
                this.bindEvents();
                this.startAnimation();
            });
        }

        waitForImages() {
            const images = this.$track.find('img').toArray();
            if (images.length === 0) {
                return Promise.resolve();
            }

            const promises = images.map(img => {
                if (img.complete && img.naturalHeight !== 0) {
                    return Promise.resolve();
                }
                return new Promise(resolve => {
                    img.onload = resolve;
                    img.onerror = resolve;
                    // Timeout fallback
                    setTimeout(resolve, 3000);
                });
            });
            return Promise.all(promises);
        }

        setupClones() {
            // Bereken totale hoogte van originele items
            this.trackHeight = 0;
            this.$items.each((i, item) => {
                this.trackHeight += $(item).outerHeight(true);
            });

            if (this.trackHeight === 0) {
                // Fallback: forceer layout berekening
                this.$track.css('visibility', 'hidden');
                this.$container.css('overflow', 'visible');

                this.$items.each((i, item) => {
                    this.trackHeight += $(item).outerHeight(true);
                });

                this.$container.css('overflow', 'hidden');
                this.$track.css('visibility', 'visible');
            }

            // Kloon items voor oneindige loop
            const containerHeight = this.$container.height();
            const clonesNeeded = Math.ceil(containerHeight / this.trackHeight) + 2;

            for (let i = 0; i < clonesNeeded; i++) {
                this.$items.clone().appendTo(this.$track);
            }

            // Bij richting "omlaag": start met negatieve positie zodat content zichtbaar is
            if (this.direction === 'down') {
                this.position = -this.trackHeight;
                this.$track.css('transform', 'translateY(' + this.position + 'px)');
            }
        }

        bindEvents() {
            if (this.pauseOnHover) {
                this.$container.on('mouseenter.mvc', () => {
                    this.isPaused = true;
                });

                this.$container.on('mouseleave.mvc', () => {
                    this.isPaused = false;
                    this.lastTime = null;
                });
            }

            // Pauzeer als niet zichtbaar
            if ('IntersectionObserver' in window) {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            if (!this.animationId) {
                                this.startAnimation();
                            }
                        } else {
                            this.stopAnimation();
                        }
                    });
                }, { threshold: 0 });

                this.observer.observe(this.$container.get(0));
            }
        }

        startAnimation() {
            if (this.animationId) return;
            this.lastTime = null;
            this.animationId = requestAnimationFrame((time) => this.animate(time));
        }

        stopAnimation() {
            if (this.animationId) {
                cancelAnimationFrame(this.animationId);
                this.animationId = null;
            }
        }

        animate(currentTime) {
            this.animationId = requestAnimationFrame((time) => this.animate(time));

            if (this.isPaused) {
                this.lastTime = null;
                return;
            }

            if (!this.lastTime) {
                this.lastTime = currentTime;
                return;
            }

            const deltaTime = (currentTime - this.lastTime) / 1000;
            this.lastTime = currentTime;

            const movement = this.speed * deltaTime;

            if (this.direction === 'up') {
                this.position -= movement;
                if (Math.abs(this.position) >= this.trackHeight) {
                    this.position += this.trackHeight;
                }
            } else {
                this.position += movement;
                if (this.position >= 0) {
                    this.position = -this.trackHeight;
                }
            }

            this.$track.css('transform', 'translateY(' + this.position + 'px)');
        }
    }

    function initCarousels() {
        $('.mvc-carousel-container').each(function() {
            if (!$(this).data('mvc-initialized')) {
                $(this).data('mvc-initialized', true);
                new VerticalCarousel(this);
            }
        });
    }

    // Init wanneer DOM klaar is
    $(function() {
        initCarousels();
    });

    // Init na window load (voor lazy loaded images)
    $(window).on('load', function() {
        initCarousels();
    });

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/satdesign_vertical_carousel.default', function($scope) {
                var $carousel = $scope.find('.mvc-carousel-container');
                if ($carousel.length && !$carousel.data('mvc-initialized')) {
                    $carousel.data('mvc-initialized', true);
                    new VerticalCarousel($carousel.get(0));
                }
            });
        }
    });

})(jQuery);
