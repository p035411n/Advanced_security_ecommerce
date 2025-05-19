document.addEventListener("DOMContentLoaded", function () {
  const paymentForm = document.getElementById("payment-form");

  paymentForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(paymentForm);

    fetch("payment_process.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
      alert(data.message); // Show alert based on response

      if (data.status === "success") {
        window.location.href = "index.php";
      }
    })
    .catch(error => {
      console.error("Payment Error:", error);
      alert("Error processing payment! Please try again.");
    });
  });
});
