const form = document.getElementById("booking-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        const check_in = formData.get("check_in");
        const check_out = formData.get("check_out");
        const room = formData.get("room");

        console.log("Form Data:");
        console.log("Check-in:", check_in);
        console.log("Check-out:", check_out);
        console.log("Room:", room);

        form.submit();
});

function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
      }

      function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
      }

      // Close when clicking outside modal
      window.onclick = function (event) {
        const loginModal = document.getElementById("loginModal");
        const registerModal = document.getElementById("registerModal");

        if (event.target === loginModal) {
          loginModal.style.display = "none";
        }

        if (event.target === registerModal) {
          registerModal.style.display = "none";
        }
};