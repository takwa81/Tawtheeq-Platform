// const progressContainer = document.querySelector('.progress-container');

// // initial call
// setPercentage();

// function setPercentage() {
//   const percentage = progressContainer.getAttribute('data-percentage') + '%';
  
//   const progressEl = progressContainer.querySelector('.progress');
//   const percentageEl = progressContainer.querySelector('.percentage');
//   progressEl.style.width = percentage;
//   if (percentageEl) {
//     percentageEl.innerText = percentage;
//     percentageEl.style.left = percentage;
//   }
// }

document.addEventListener("DOMContentLoaded", function () {
  const progressContainers = document.querySelectorAll('.progress-container');

  progressContainers.forEach(container => {
    const percentageValue = container.getAttribute('data-percentage') + '%';
    const progressEl = container.querySelector('.progress');
    const percentageEl = container.querySelector('.percentage');

    if (progressEl) {
      progressEl.style.width = percentageValue;
    }

    if (percentageEl) {
      percentageEl.innerText = percentageValue;
      percentageEl.style.left = percentageValue;
    }
  });
});
