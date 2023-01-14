 <head>
        <style>
    .open {
	cursor:pointer; 
}
#pop-up {
	display: none;
}
.overlay {
	display: none; 
}
#pop-up:checked + .overlay {
	display: block;
	z-index: 9999;
	background-color: #00000070;
	position: fixed;
	width: 100%;
	height: 100vh;
	top: 0;
	left: 0;
}
.window {
	width: 90vw;
	max-width: 380px;
	height: 80px;
	background-color: #ffffff;
	border-radius: 6px;
	/*display: flex;*/
	justify-content: center;
	align-items: center;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.text {
	font-size: 18px;
	margin: 0;

}
a {
    color:blue;
}

.close {
	cursor:pointer;
	position: absolute;
	top: 4px;
	right: 4px;
	font-size: 20px;
}
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
  <link href="style.css"rel="stylesheet">
</head>
<script src="https://kit.fontawesome.com/a60744fb42.js" crossorigin="anonymous"></script>
<div class="relative bg-[#c2e3ff] h-14 w-auto ">
    <a href="/" class="text-3xl text-[#333333]">Spesh</a>
  <div class="w-auto h-14 py-2 absolute bottom-0 right-0 ">
    <a class="text-black" href="https://github.com/Spesh-dev"><i class="fa-brands fa-github fa-2xl mx-2"></i></a>
    <a class="text-black" href="https://twitter.com/Kota_pclive"><i class="fa-brands fa-twitter fa-2xl mx-2"></i></a>
    <a class="text-black" href="mailto:spesh-contact@skota11.com"><i class="fa-regular fa-envelope fa-2xl mx-2"></i></a>
  </div>
</div>