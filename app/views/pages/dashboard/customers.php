<?php require ROOT . "/views/includes/header.php"; ?>

<?php require ROOT . "/views/includes/nav.php"; ?>

<?php require ROOT . "/views/includes/back_to_dashboard.php"; ?>

<?php require ROOT . "/views/includes/error_modal.php"; ?>

<div class="p-2">
    <div class="max-w-lg mx-auto border shadow-lg rounded-md">
        <div class="bg-[#3B5998] flex items-center justify-around rounded-t-md">
            <h1 class="text-white rounded-none p-2 font-bold text-xl">Customers</h1>
            <a href="#addCustomer" class="text-purple-800 text-sm bg-[#B9CFFB] px-2 font-bold cursor-pointer rounded-md">ADD</a>
        </div>
        
        <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="px-2 py-1 md:px-4 text-xs md:py-2">Id</th>
                    <th class="px-2 py-1 md:px-4 text-xs md:py-2">Name</th>
                    <th class="px-2 py-1 md:px-4 text-xs md:py-2">Contact</th>
                    <th class="px-2 py-1 md:px-4 text-xs md:py-2">Purchase History</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 0; $i < count($data); $i++) { ?>
                <tr class="bg-white">
                    <td class="px-4 py-4 text-xs text-center"><?php echo $i + 1; ?></td>
                    <td class="px-4 py-4 text-xs text-center"><?php echo $data[$i]->name; ?></td>
                    <td class="px-4 py-4 text-xs text-center"><?php echo $data[$i]->contact; ?></td>
                    <td class="hide_<?php echo $i + 1; ?> hidden"><?php echo $data[$i]->p_history; ?></td>
                    <td class="text-center"><button id="btn_<?php echo $i + 1; ?>" class="bg-[#E3BA27] py-1 font-bold w-16 text-sm  show-dialog rounded-md text-blue-800">View</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<form action="<?php echo APP_URL; ?>/companies/customers/create" method="post" class="max-w-lg mt-4 mx-auto p-4">
    <h1 class="text-center text-xl my-4 font-bold" id="addCustomer">Add Customer</h1>
    <div class="w-full pt-2">
        <input type="text" name="name" class="p-4 rounded-md border-l-4 border-l-blue-800 w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Name">
    </div>
    <div class="w-full pt-2">
        <input type="number" name="contact" class="p-4 rounded-md border-l-4 border-l-blue-800 w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Contact">
    </div>
    <div class="w-full pt-2">
        <textarea name="hist" class="p-4 rounded-md border-l-4 border-l-blue-800 w-full outline-none focus:border-blue-500 bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Purchase History .i.e 200,7000,400"></textarea>
    </div>
    <button type="submit" onclick="spin(event)" class="text-blue-800 underline-none rounded-md bg-[#E3BA27] p-2 mt-4 font-bold w-40 mx-auto block">Add customer</button>
</form>

<dialog id="dialog"></dialog>


<script>
const showBtn = document.querySelectorAll(".show-dialog");
const dialog = document.getElementById("dialog");
const body = document.querySelector("body");

let jsCloseBtn;



showBtn.forEach(btn => btn.addEventListener("click", () => {
    
    btnId = btn.id.split("_")[1];

    hist = document.querySelector(`.hide_${btnId}`).innerHTML.split(",");

    // id = document.querySelector(`.id_${btnId}`).innerHTML;
  
    dialog.innerHTML = `
    <div class="max-w-lg mx-auto border shadow-lg rounded-none">
        <div class="bg-[#3B5998] flex items-center justify-around gap-x-6 py-2">
            <h1 class="text-white rounded-none py-2 pl-4 font-bold text-md">Purchase History</h1>
            <button id="js-close" class="text-white text-xl bg-red-500 mx-4 py-1 px-3 rounded-full font-bold cursor-pointer">x</button>
        </div>
        
        <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Day</th>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Total</th>
                </tr>
            </thead>
            <tbody id="t-body">
            </tbody>
        </table>
    </div>
    </div>
    `;

    for(let i = 0; i < hist.length; i++){
        dialog.querySelector("#t-body").innerHTML += `
        <tr class="bg-white">
            <td class="px-2 py-2 md:px-4 md:py-2 text-xs text-center">${i + 1}</td>
            <td class="px-2 py-2 md:px-4 md:py-2 text-xs text-center">${hist[i]}</td>
        </tr>
    `;
    }
    
  
    jsCloseBtn = dialog.querySelector("#js-close");
  
    jsCloseBtn.addEventListener("click", (e) => {
          e.preventDefault();
          dialog.close();
          body.style.overflowY = "scroll";
    });
  
    dialog.showModal();
    body.style.overflowY = "hidden";
  }));

  setTimeout(() => {
    document.querySelector(".err")?.classList.add("hidden");
}, 3000)

function spin(e){
    e.target.innerHTML = `<i class="fa fa-circle-o-notch fa-spin text-white" style="font-size: 24px;"></i>`;
}
</script>


<?php require ROOT . "/views/includes/footer.php"; ?>
