document.addEventListener("DOMContentLoaded", function () {
  const popups = document.querySelectorAll(".ssn-popup");

  popups.forEach((popup) => {
    const position = popup.dataset.position || "bottom-left";
    const entrance = popup.dataset.entrance || "slide-in";
    const exit = popup.dataset.exit || "slide-out";
    const offsetX = popup.dataset.offsetX || "20";
    const offsetY = popup.dataset.offsetY || "20";

    // Apply position and offset
    popup.classList.add(position);
    if (position.includes("top")) {
      popup.style.top = offsetY + "px";
    } else {
      popup.style.bottom = offsetY + "px";
    }
    if (position.includes("left")) {
      popup.style.left = offsetX + "px";
    } else {
      popup.style.right = offsetX + "px";
    }

    // Show popup
    popup.classList.add(entrance);

    // Hide popup after 5 seconds
    setTimeout(() => {
      popup.classList.remove(entrance);
      popup.classList.add(exit);
      popup.addEventListener("animationend", () => {
        popup.remove();
      });
    }, 5000);
  });
});
