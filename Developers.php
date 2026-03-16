<?php
$pageTitle = 'Developers · Plant-Hub';
$active = '';
require __DIR__ . '/partials/header.php';
?>

<section class="py-12 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      
      <!-- Left side: Developer boxes -->
      <div class="space-y-6">
        <!-- Title Box -->
        <div class="border-8 border-green-700 rounded-3xl p-4 text-center">
          <h1 class="text-4xl font-bold text-green-800">About Developers</h1>
        </div>
  
        <!-- Name + Roles Box -->
        <div class="border-2 border-green-700 rounded-3xl p-6 flex flex-col md:flex-row justify-between">
          <!-- Developer List -->
          <div>
              <h2 class="text-green-900 font-bold text-center">DEVELOPERS</h2>
            <ol class="list-decimal pl-5 space-y-1 text-green-800">
            <!-- Github Url pasting -->
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Harsh</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Ankit</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Aditya</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Areeb Ali</a></li>
            </ol>
          </div>
  
          <!-- Roles -->
          <div class="mt-10 md:mt-0 md:ml-10 space-y-1 text-green-800 p-4">
            <p class="text-xl font-bold">1. PHP, SQL, RestAPI's.</p>
            <p class="text-xl font-bold">2. Designing Using Bootstrap and CSS.</p>
            <p class="text-xl font-bold">3. Logical implementation using JS.</p>
            <p class="text-xl font-bold">4. Chatbot, Deployment and Testing</p>
          </div>
        </div>
      </div>
  
      <!-- Right side: Illustration -->
      <div class="flex justify-center">
        <!-- Replace the below with your actual SVG or image -->
        <img src="png3.png" alt="Developer Illustration" class="w-auto h-auto" loading="lazy">
      </div>
  
    </div>

</section>
  
<?php require __DIR__ . '/partials/footer.php'; ?>