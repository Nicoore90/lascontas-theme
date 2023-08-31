document.addEventListener('DOMContentLoaded', function() {
    const carouselItems = document.querySelectorAll('.carousel-item');
    let currentIndex = 0;
    let timeInterval = 5000;

    function showSlide(index) {
        indexNext = index + 1
        indexBefore = index == 0 ? 2 : index - 1
        if(indexNext > carouselItems.length - 1){
            indexNext = 3
        }
        if (index < 0) {
            index = carouselItems.length - 1;
        } else if (index >= carouselItems.length) {
            index = 0;
        }
        if(indexBefore == carouselItems.length - 2 && index == carouselItems.length - 1 && indexNext == carouselItems.length - 3){
            indexBefore = 2
            index = 0
            indexNext = 1
        }
        carouselItems.forEach(item => item.style.display = 'none');
        if(screen.width > 768){
            carouselItems[indexBefore].style.display = 'block';
            carouselItems[indexBefore].className += ' no-principal'
            carouselItems[indexNext].style.display = 'block';
            carouselItems[indexNext].className += ' no-principal'
        }
        carouselItems[index].style.display = 'block';
        carouselItems[index].classList.remove('no-principal')
        currentIndex = index;
    }

    function showNextSlide() {
      showSlide(currentIndex + 1);
    }

    showSlide(currentIndex);
    setInterval(showNextSlide, timeInterval);

    document.querySelector('.carousel-control.prev').addEventListener('click', function() {
      currentIndex == 0 ? 0 : showSlide(currentIndex - 1);
    });

    document.querySelector('.carousel-control.next').addEventListener('click', function() {
      showNextSlide();
    });
  });