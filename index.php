<?php
$pageTitle = 'Plant-Hub';
$active = 'home';
require __DIR__ . '/partials/header.php';
?>

<section id="home" class="flex flex-col items-center">
    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
        <div class="w-full md:w-72 h-auto">
            <img src="png1.png" alt="Garden portrait 1" class="w-full h-auto mt-20" loading="lazy">
        </div>
        
        <div class="flex flex-col text-center mt-20 items-center">
            <h1 class="font-extrabold text-4xl md:text-6xl text-emerald-900">The Benefits of Gardening.</h1>
            <div class="text-center border-4 border-solid rounded-2xl w-72 h-42 text-3xl font-[Times] text-black font-extrabold mt-12 border-black p-4">
                Improving Life with the Magic of Nature
            </div>
        </div>

        <div class="w-full md:w-72 h-auto mt-20">
            <img src="png2.png" alt="Garden portrait 2" class="w-full h-auto" loading="lazy">
        </div>
    </div>
    <!-- images slider -->
    <div class="relative w-full overflow-hidden mt-10">
        <div class="ph-slider relative flex mb-2 mt-2">
            <img src="https://harddy.com/cdn/shop/articles/Gardening_with_Family_9eced38f-b650-4b68-80e3-6ad9826cf1d0_1200x1200.jpg?v=1576111862" class="is-active" alt="Garden 1" loading="lazy">
            <img src="https://media.istockphoto.com/id/539829042/photo/proud-gardener.jpg?s=612x612&w=0&k=20&c=WrhKK9tgxLds1ikZYabVsHSGxay65NpMO8ICz-5uwRo=" alt="Garden 2" loading="lazy">
            <img src="https://media.istockphoto.com/id/1445716627/photo/woman-gardening-herbs-in-her-garden.jpg?s=612x612&w=0&k=20&c=tqMYF60u5xwwesZwJEKIT6OzBBVVxs-blBnSburU59E=" alt="Garden 3" loading="lazy">
        </div>
    
        <!-- Navigation Buttons -->
        <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 text-white px-4 py-2 rounded-full">❮</button>
        <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 text-white px-4 py-2 rounded-full">❯</button>
    </div>  
    
    <script>
        //image slider logic
        let index = 0;
        const images = document.querySelectorAll('.ph-slider img');
        const totalImages = images.length;

        function showImage(i) {
            images.forEach(img => img.classList.remove('is-active'));
            images[i].classList.add('is-active');
        }

        function nextImage() {
            index = (index + 1) % totalImages;
            showImage(index);
        }

        function prevImage() {
            index = (index - 1 + totalImages) % totalImages;
            showImage(index);
        }

        document.getElementById('next').addEventListener('click', nextImage);
        document.getElementById('prev').addEventListener('click', prevImage);
        
        setInterval(nextImage, 5000); // Auto-slide every 5 seconds
    </script>
</section>

<!-- Services Section -->
<section id="services" class="mt-0 mb-10 rounded-2xl">
    <div class="flex justify-center items-center">
        <h1 class="w-64 h-24 ml-0 rounded-3xl text-center font-extrabold text-6xl text-emerald-900 p-20 mr-12 mb-4">
            Services
        </h1>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between">
        <!-- Image on the left -->
        <div class="w-full md:w-1/2 h-auto">
            <img src="png4.png" alt="Grass1" class="rounded-xl object-cover w-full" loading="lazy">
        </div>

        <!-- Text on the right -->
        <div class="w-full md:w-1/2 h-auto rounded-2xl text-2xl p-6 text-left">
            <h1 class="font-bold italic">
                Welcome to <span class="text-green-600">PlantHub</span>, your go-to Community Garden Platform! 🌿✨<br><br>
                At PlantHub, we believe in the power of gardening to bring people together. Whether you're a seasoned gardener or just starting, our platform connects garden enthusiasts, urban farmers, and eco-conscious individuals to share knowledge, resources, and experiences.<br><br>
                🌍 <strong>Our Mission:</strong> To foster a sustainable and green community by making gardening accessible to everyone.
            </h1>
        </div>
    </div>

    <div class="flex flex-row items-center">
        <div class="flex-1 p-8">
            <h1 class="font-medium font-[Times] text-3xl text-gray-800 ml-2">Property Managers</h1>
            <p class="text-2xl font-bold text-gray-800">
                Turn-key property managers for private landowners. Year-round property management and maintenance including:
                boulevard maintenance, grass cutting, leaf removal, and more.
            </p>
        </div>

        <div class="w-80 h-72 mr-8">
            <img src="https://www.ugaoo.com/cdn/shop/articles/shutterstock_139759228_eb50c5c7-3293-4358-aac1-03e0ef67a383.jpg?v=1661768042" alt="services1" class="w-full h-full object-cover rounded-lg" loading="lazy">
        </div>
    </div>

    <div class="flex flex-row items-center mt-10">
        <div class="flex-1 p-8">
            <h1 class="font-medium font-[Times] text-3xl text-gray-800 ml-2">Interim Land-use</h1>
            <p class="text-2xl font-bold text-gray-800">
                Our gardens are built in 1-5 days and the average timeline for our projects range from 1-5 years. 
                We have clear rules and agreements with all our gardeners, renewing annually with a 30-day removal clause. 
                We take our projects growing season by growing season. 
            </p>
        </div>

        <div class="w-80 h-72 mr-8">
            <img src="https://images.immediate.co.uk/production/volatile/sites/10/2018/10/2048x1365-No-dig-gardening-Charles_Dowding_JI_160817_CharlesDowding_125-7958889.jpg?resize=768,574" alt="services1" class="w-full h-full object-cover rounded-lg" loading="lazy">
        </div>
    </div>

    <div class="flex flex-row items-center mt-10">
        <div class="flex-1 p-8">
            <h1 class="font-medium font-[Times] text-3xl text-gray-800 ml-2">Dog Garden🐾 </h1>
            <p class="text-2xl font-bold text-gray-800">
                A dog park where dogs run free. 
                We create purpose built parks for dogs to exercise and play off-leash in a controlled environment under the supervision of their owners. 
                Dog owners can let their dogs roam free with peace of mind, while sharing the experience with other people & their pets. 
            </p>
        </div>

        <div class="w-80 h-72 mr-8">
            <img src="https://images.theconversation.com/files/625049/original/file-20241010-15-95v3ha.jpg?ixlib=rb-4.1.0&rect=4%2C12%2C2679%2C1521&q=20&auto=format&w=320&fit=clip&dpr=2&usm=12&cs=strip" alt="services1" class="w-full h-full object-cover rounded-lg" loading="lazy">
        </div>
    </div>
</section>

<section id="garden" class="mt-24">
    <h1 class="text-center font-extrabold text-4xl font-sans text-emerald-800 mt-5">
        <strong>Active Community Garden Projects</strong>
    </h1>

    <div class="flex flex-row flex-wrap gap-6 mt-6 mx-4 justify-between items-stretch">
        <!-- garden card -->
        <div class="flex flex-col w-full md:w-[32%] rounded-2xl shadow-lg overflow-hidden">
            <h1 class="text-3xl text-gray-800 mt-6 mb-4 font-bold text-center">
                <a href="#" class="hover:text-green-500">Plants Paradise</a>
            </h1>
            <a href="#">
                <img src="https://thumbs.dreamstime.com/b/professional-gardener-finishing-newly-developed-backyard-garden-planting-last-decorative-trees-168604803.jpg" 
                    alt="Plants Paradise" 
                    class="w-full aspect-[4/3] object-cover mb-4" loading="lazy">
            </a>
            <p class="text-black font-medium text-2xl p-4 flex-grow">
                The <strong class="text-3xl text-emerald-600 hover:text-emerald-950 hover:underline">Plants Paradise</strong> is a growing and developing community Nursery for plants located at Old Phagwara Rd, opp. Volkswagon workshop, Jalandhar, Punjab 144024.
            </p>
        </div>

        <div class="flex flex-col w-full md:w-[32%] rounded-2xl shadow-lg overflow-hidden">
            <h1 class="text-3xl text-gray-800 mt-6 mb-4 font-bold text-center">
                <a href="#" class="hover:text-green-500">Back Garden Nursery</a>
            </h1>
            <a href="#">
                <img src="https://media.istockphoto.com/id/1385759203/photo/soil-with-a-young-plant-planting-seedlings-in-the-ground-there-is-a-spatula-nearby-the.jpg?s=612x612&w=0&k=20&c=gmEFj5-5ZP8PnX74ostHb0G8hzUKSIKR_qxnjpBHHvg=" 
                    alt="Back Garden Nursery" 
                    class="w-full aspect-[4/3] object-cover mb-4" loading="lazy">
            </a>
            <p class="text-black font-medium text-2xl p-4 flex-grow">
                The <strong class="text-3xl text-emerald-600 hover:text-emerald-950 hover:underline">Back Garden Nursery</strong> is one of the best community Garden in the Punjab for plants located at 9 A, opp. Income Tax Colony, Jyoti Nagar, Jalandhar, Punjab 144001.
            </p>
        </div>

        <div class="flex flex-col w-full md:w-[32%] rounded-2xl shadow-lg overflow-hidden">
            <h1 class="text-3xl text-gray-800 mt-6 mb-4 font-bold text-center">
                <a href="#" class="hover:text-green-500">RK Nursery</a>
            </h1>
            <a href="#">
                <img src="https://img.freepik.com/free-photo/overhead-view-hand-holding-small-fresh-potted-plant_23-2147844319.jpg?semt=ais_hybrid&w=740" 
                    alt="RK Nursery" 
                    class="w-full aspect-[4/3] object-cover mb-4" loading="lazy">
            </a>
            <p class="text-black font-medium text-2xl p-4 flex-grow">
                The <strong class="text-3xl text-emerald-600 hover:text-emerald-950 hover:underline">RK Nursery</strong> is a famous and one of the old Nursery in the city for plants located at Grand Trunk Rd, Goraya, Punjab 144409.
            </p>
        </div>
    </div>

    <script>
        window.addEventListener('load', equalizeCardHeights);
        window.addEventListener('resize', equalizeCardHeights);
    
        function equalizeCardHeights() {
            const cards = document.querySelectorAll('#garden .flex-col');
            let maxHeight = 0;
    
            cards.forEach(card => {
                card.style.height = 'auto'; // Reset height
                if (card.offsetHeight > maxHeight) {
                    maxHeight = card.offsetHeight;
                }
            });
    
            cards.forEach(card => {
                card.style.height = maxHeight + 'px';
            });
        }
    </script>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>