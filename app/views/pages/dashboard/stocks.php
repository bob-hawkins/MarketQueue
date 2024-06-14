<?php require ROOT . "/views/includes/header.php"; ?>

<?php require ROOT . "/views/includes/nav.php"; ?>

<?php require ROOT . "/views/includes/back_to_dashboard.php"; ?>

<?php require ROOT . "/views/includes/error_modal.php"; ?>

<div class="p-2">
    <div class="max-w-lg mx-auto border shadow-lg rounded-none">
        <div class="bg-[#3B5998] flex items-center justify-around">
            <h1 class="text-white rounded-none p-2 font-bold text-xl">Stocks</h1>
            <a href="#addCustomer" class="text-purple-800 text-sm bg-[#B9CFFB] px-2 font-bold cursor-pointer">ADD</a>
        </div>
        
        <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Id</th>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Name</th>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Price</th>
                    <th class="px-2 py-2 md:px-4 text-xs md:py-2">Edit</th>
                </tr>
            </thead>
            <tbody>
        
                <?php for($i = 0; $i < count($data); $i++) { ?>
                <tr class="bg-white">
                    <td class="px-4 py-4 md:px-4 md:py-2 text-xs text-center"><?php echo $i + 1; ?></td>
                    <td class="name_<?php echo $data[$i]->id; ?> px-4 py-4 md:px-4 md:py-2 text-xs text-center"><?php echo $data[$i]->name; ?></td>
                    <td class="price_<?php echo $data[$i]->id; ?> px-4 py-4 md:px-4 md:py-2 text-xs text-center"><?php echo $data[$i]->price; ?></td>
                    <td class="text-center"><button id="cl_<?php echo $data[$i]->id; ?>" class="bg-[#E3BA27] w-16 text-sm show-dialog">View</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<form action="<?php echo APP_URL; ?>/companies/stocks/create" method="post" class="max-w-lg mt-4 mx-auto p-4">
    <h1 class="text-center text-xl my-4 font-bold" id="addCustomer">Add Stock</h1>
    <div class="w-full pt-2">
        <input type="text" name="name" class="p-4  border-l-4 border-l-blue-800 w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Name">
    </div>
    <div class="w-full py-4">
        <input type="number" name="price" class="p-4  border-l-4 border-l-blue-800 w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Price">
    </div>

    <button onclick="spin(event)" type="submit" class="underline-none bg-[#E3BA27] p-2 mb-6 font-bold w-40 ml-auto block">Add Stock</button>
</form>

<dialog id="dialog" class="w-[300px]"></dialog>
<!-- <output></output> -->

<script>


const showBtn = document.querySelectorAll(".show-dialog");
const dialog = document.getElementById("dialog");
const body = document.querySelector("body");
let jsCloseBtn;


showBtn.forEach(btn => btn.addEventListener("click", () => {
    
  id = btn.id.split("_")[1];
  
  name = document.querySelector(`.name_${id}`).innerHTML
  price = document.querySelector(`.price_${id}`).innerHTML;
//   id = document.querySelector(`#id_${btnId}`).id.split["_"][1];

  dialog.innerHTML = `
  <form action="<?php echo APP_URL; ?>/companies/stocks/edit" method="post" class="w-full mt-4 p-4 px-6">
    <h1 class="text-center text-xl my-4 font-bold" id="addCustomer">Edit Stock</h1>
    <input type="hidden" name="id" value="${id}" class="p-2 rounded-xl w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Name">

    <div class="w-full pt-2">
        <input type="text" name="name" value="${name}" class="p-2 rounded-xl w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Name">
    </div>
    <div class="w-full pt-2">
        <input type="number" name="price" value="${price}" class="p-2 rounded-xl w-full outline-none bg-[#B9CFF8] placeholder-[#3B5998]" placeholder="Price">
    </div>

    <div class="grid grid-cols-2 gap-x-2">
        <button onclick="spin(event)" class="underline-none bg-[#E3BA27] rounded-xl p-2 mt-4 font-bold w-24 text-white mx-auto block">Edit</button>
        <button id="js-close" class="underline-none bg-[#E3BA27] rounded-xl p-2 mt-4 font-bold w-24 text-white mx-auto block">Cancel</button>
    </div>
    
    </div>
  </form>
  `;

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