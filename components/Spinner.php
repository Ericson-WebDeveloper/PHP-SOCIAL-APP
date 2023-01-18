<div class="overlay-content">
  <div class="spinner"></div>  
</div>


<style>
.spinner {
   width: 56px;
   height: 56px;
   display: grid;
   animation: spinner-plncf9 4s infinite;
}

.spinner::before,
.spinner::after {
   content: "";
   grid-area: 1/1;
   border: 9px solid;
   border-radius: 50%;
   border-color: rgba(71, 78, 255, 0.99) rgba(71, 78, 255, 0.99) #0000 #0000;
   mix-blend-mode: darken;
   animation: spinner-plncf9 1s infinite linear;
}

.spinner::after {
   border-color: #0000 #0000 #dbdcef #dbdcef;
   animation-direction: reverse;
}

@keyframes spinner-plncf9 {
   100% {
      transform: rotate(1turn);
   }
}


.overlay  {
  opacity:    0.5; 
  background: #000; 
  width:      100%;
  height:     100%; 
  z-index:    10;
  top:        0; 
  left:       0; 
  position:   fixed; 
}

/* Position the content inside the overlay */
.overlay-content {
  position: relative;
  top: 25%; /* 25% from the top */
  width: 100%; /* 100% width */
  text-align: center; /* Centered text/links */
  margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
}

/* The navigation links inside the overlay */
.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block; /* Display block instead of inline */
  transition: 0.3s; /* Transition effects on hover (color) */
}

/* When you mouse over the navigation links, change their color */
.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

/* Position the close button (top right corner) */
.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
}

/* When the height of the screen is less than 450 pixels, change the font-size of the links and position the close button again, so they don't overlap */
@media screen and (max-height: 450px) {
  .overlay a {font-size: 20px}
  .overlay .closebtn {
    font-size: 40px;
    top: 15px;
    right: 35px;
  }
}
</style>

