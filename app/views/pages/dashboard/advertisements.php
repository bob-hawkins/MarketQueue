<?php require ROOT . "/views/includes/header.php"; ?>

<?php require ROOT . "/views/includes/nav.php"; ?>

<?php require ROOT . "/views/includes/back_to_dashboard.php"; ?>

<?php require ROOT . "/views/includes/error_modal.php"; ?>

<h1 class="text-xl sm:text-3xl text-center font-bold ">ADVERTISEMENTS</h1>

<div data-category="instructions" class="p-2">
    <div class="mx-auto max-w-lg">
        <p class="text-xl mt-4">How it works?</p>
        <ul class="list-decimal ml-6">
            <!-- <li class="text-sm">Select the item you want to advertise.</li>
            <li class="text-sm">If the item is discounted, tag it as discount else new.</li> -->
            <li class="text-sm">The app will pick the target customers from the list of customers whose last purchase history  meets the limit you set.</li>
            <li class="text-sm">Send the advert in form of sms.</li>
            <li class="text-sm">Once delivered to the recepients, the app will notify you.</li>
        </ul>
    </div>
</div>

<form action="<?php echo APP_URL; ?>/companies/advertisements/send" method="post" class="max-w-lg mt-4 mx-auto p-4 mb-10">
    <!-- <h1 class="text-center text-xl my-4 font-bold" id="addCustomer"></h1> -->
    <!-- <div class="w-full pt-4">
        <input type="text" name="stock" class="border-l-4 border-l-blue-800 p-4 w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Name of Stock">
    </div> -->
    <!-- <div class="w-full pt-4">
        <select name="tag" class="p-4 w-full border-l-4 border-l-blue-800 outline-none bg-[#B9CFF8] text-[#3B5998]">
            <option value="" disabled selected>Select a tag</option>
            <option value="discount">Discount</option>
            <option value="new">New</option>
        </select>
    </div> -->
    <div class="w-full pt-4">
        <input type="number" name="limit" class="p-4 w-full rounded-md border-l-4 border-l-blue-800 mb-4 outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Purchase History Limit">
    </div>
    <div class="w-full pt-2">
        <textarea name="advert" class="p-4 h-24  border-l-4 rounded-md border-l-blue-800 w-full outline-none focus:border-blue-500 bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Advertisement message...."></textarea>
    </div>

    <button onclick="spin(event)" type="submit" class="text-blue-800 underline-none rounded-md bg-[#E3BA27] p-2 mt-4 font-bold w-40 mx-auto block">Send SMS</button>
</form>

<script>

setTimeout(() => {
    document.querySelector(".err").classList.add("hidden");
}, 3000)

    function spin(e){
    e.target.innerHTML = `<i class="fa fa-circle-o-notch fa-spin text-white" style="font-size: 24px;"></i>`;
}
</script>


<?php require ROOT . "/views/includes/footer.php"; ?>