document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const status = params.get("status");

  if (status === "success") {
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Item added successfully!",
    });
  } else if (status === "invalidformat") {
    Swal.fire({
      icon: "error",
      title: "Invalid Format",
      text: "Only JPG, PNG, and GIF images are allowed.",
    });
  } else if (status === "invalidprice") {
    Swal.fire({
      icon: "warning",
      title: "Invalid Price",
      text: "Price must be a positive number.",
    });
  } else if (status === "deleted") {
    Swal.fire({
      icon: "success",
      title: "Deleted",
      text: "Category deleted successfully!",
    });
  } else if (status === "error") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Something went wrong while deleting the category.",
    });
  }

  // ✅ Clean up URL so popup doesn't reappear on refresh
  if (status) {
    history.replaceState(null, "", window.location.pathname);
  }
});
