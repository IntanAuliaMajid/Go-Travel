const loadMoreBtn = document.getElementById("loadMore");
const galleryContainer = document.getElementById("gallery-container");

const additionalImages = [
  "https://tugujatim.id/wp-content/uploads/2023/10/WhatsApp-Image-2023-10-20-at-16.12.53.jpeg",
  "https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg",
  "https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg",
  "https://anekatempatwisata.com/wp-content/uploads/2018/04/Jakarta-Aquarium-loop.jpg",
  "https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg",
  "https://anekatempatwisata.com/wp-content/uploads/2018/04/Dunia-Fantasi-klook.png",
  "https://www.nativeindonesia.com/foto/2024/03/pantai-pasir-putih-tlongoh.jpg",
  'https://dimadura.id/wp-content/uploads/2025/04/Mercusuar-Sembilangan_Wisata-Sejarah-di-Bangkalan_-1.jpg',
  "https://labuhanmangrove.files.wordpress.com/2019/09/whatsapp-image-2019-09-11-at-10.58.31-1.jpeg"
];

let loadCount = 0;

loadMoreBtn.addEventListener("click", () => {
  const nextImages = additionalImages.slice(loadCount, loadCount + 4);
  nextImages.forEach(src => {
    const img = document.createElement("img");
    img.src = src;
    img.alt = "Foto Tambahan";
    galleryContainer.appendChild(img);
  });

  loadCount += 4;
  if (loadCount >= additionalImages.length) {
    loadMoreBtn.style.display = "none";
  }
});
