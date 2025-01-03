const menuItems = document.querySelectorAll(".menu a");
const sections = document.querySelectorAll(".section");
menuItems.forEach((item) => {
  item.addEventListener("click", (event) => {
    event.preventDefault();
    menuItems.forEach((menuItem) => menuItem.classList.remove("active"));
    item.classList.add("active");
    sections.forEach((section) => {
      section.style.display = "none";
    });
    const sectionId = item.getAttribute("data-section");
    const activeSection = document.getElementById(sectionId);
    if (activeSection) {
      activeSection.style.display = "block";
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  sections.forEach((section) => (section.style.display = "none"));
  document.getElementById("dashboard").style.display = "block";
});
// // Modal thêm sản phẩm
// const openModalBtn = document.getElementById('openModalBtn');
// const closeModalBtn = document.getElementById('closeModalBtn');
// const addProductModal = document.getElementById('addProductModal');

// openModalBtn.addEventListener('click', () => {
//   addProductModal.style.display = 'block';
// });

// closeModalBtn.addEventListener('click', () => {
//   addProductModal.style.display = 'none';
// });

// window.addEventListener('click', (event) => {
//   if (event.target === addProductModal) {
//       addProductModal.style.display = 'none';
//   }
// });

// const editModal = document.getElementById('editModal');
// const closeEditModal = document.getElementById('closeEditModal');
// const editForm = document.getElementById('editForm');

// // Hàm mở modal và cập nhật dữ liệu
// function openEditModal(productId, name, price, stock) {
//     // Hiển thị modal
//     editModal.style.display = 'block';

//     // Gán dữ liệu vào form
//     document.getElementById('product_id').value = productId;
//     document.getElementById('edit_name').value = name;
//     document.getElementById('edit_price').value = price;
//     document.getElementById('edit_stock').value = stock;

//     // Cập nhật action động cho form
//     editForm.action = `SneakerHome/admin/updateProduct/${productId}`;
// }

// // Đóng modal khi nhấn vào nút 'X'
// closeEditModal.addEventListener('click', () => {
//     editModal.style.display = 'none';
// });

// // Đóng modal khi click bên ngoài modal
// window.addEventListener('click', (event) => {
//     if (event.target === editModal) {
//         editModal.style.display = 'none';
//     }
// });
