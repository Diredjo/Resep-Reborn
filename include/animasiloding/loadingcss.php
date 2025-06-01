<style>

/* Transisi masuk-keluar halaman */
body.transitioning {
  pointer-events: none;
  overflow: hidden;
}

.magic-text {
  transform: rotate(15deg);
}

#page-transition {
  position: fixed;
  top: 45%; left: 48.5%;
  width: 5vw; height: 10vh;
  border-radius: 20px;
  z-index: 9999;
  background: radial-gradient(circle at center,rgb(65, 65, 65),rgb(0, 0, 0));
  background-size: 400% 400%;
  animation: gradientFlow 4s ease infinite;
  opacity: 1;
  transition: opacity 0.6s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  font-family: 'Poppins', sans-serif;
  font-size: 2rem;
  letter-spacing: 1px;
}

/* Magic Loading Text */
#page-transition .magic-text {
  animation: flicker 5s infinite;
  text-shadow: 0 0 10px rgba(255,255,255,0.4), 0 0 20px rgba(255,255,255,0.2);
}

/* Hide after loaded */
#page-transition.hide {
  opacity: 0;
  pointer-events: none;
}

@keyframes gradientFlow {
  0% {background-position: 0% 50%;}
  50% {background-position: 100% 50%;}
  100% {background-position: 0% 50%;}
}

@keyframes flicker {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.8; }
  75% { opacity: 0.1; }
}
</style>