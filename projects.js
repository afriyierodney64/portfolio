  function openPreview(id) {
    const modal = document.getElementById(id);
    modal.classList.add("active");
  }

  function closePreview(id) {
    const modal = document.getElementById(id);
    modal.classList.remove("active");
  }
