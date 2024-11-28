let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
let total = 0;

function mostrarCarrito(){
    
        const cart = document.getElementById("carrito");
        cart.classList.toggle("carrito-visible");
        cart.classList.toggle("carrito-escondido");

}
let cart = [];

// Función para agregar productos al carrito
function agregarAlCarrito(nombreProducto, imagenProducto, precioProducto) {
  // Crear un objeto de producto
  const product = {
    nombre: nombreProducto,
    imagen: imagenProducto,
    precio: precioProducto,
  };

  // Agregar el producto al carrito
  cart.push(product);

  // Actualizar el carrito en la interfaz
  actualizarCarrito();
}

// Función para actualizar la visualización del carrito
function actualizarCarrito() {
  const carritoItems = document.getElementById("carrito-lista");
  const precioTotalEl = document.getElementById("total");
  
  // Vaciar el contenido actual del carrito
  carritoItems.innerHTML = "";

  // Variables para el total
  let precioTotal = 0;

  // Recorrer los productos del carrito y mostrarlos
  cart.forEach((product) => {
    const item = document.createElement("li");

    const img = document.createElement("img");
    img.src = product.imagen;
    img.alt = product.nombre;
    img.style.width = "5vw"; 
    img.style.marginRight = "10px";

    const text = document.createElement("span");
    text.textContent = `${product.nombre} - $${product.precio.toFixed(2)}`;
    item.appendChild(img);
    item.appendChild(text);
    carritoItems.appendChild(item);

    // Sumar el precio de cada producto al total
    precioTotal += product.precio;
  });

  // Actualizar el precio total
  precioTotalEl.textContent = precioTotal.toFixed(2);
}
function vaciarCarrito(){
    cart = [];
    actualizarCarrito();
}

function finalizarCompra() {
  if (cart.length === 0) {
      alert("El carrito está vacío.");
      return;
  }
  // Mostrar mensaje de confirmación de compra
  alert("Compra finalizada. Gracias por su compra.");

  // Vaciar el carrito
  vaciarCarrito();
}
