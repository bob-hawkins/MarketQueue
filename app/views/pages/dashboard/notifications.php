<?php require ROOT . "/views/includes/header.php"; ?>

<?php require ROOT . "/views/includes/nav.php"; ?>

<?php require ROOT . "/views/includes/back_to_dashboard.php"; ?>

<div class="p-2">
    <div class="max-w-lg mx-auto border shadow-lg rounded-md">
        <h1 class="bg-[#3B5998] text-white text-center rounded-t-md p-2 font-bold text-xl">Notifications</h1>
        <?php foreach($data as $notification) { ?>
            <div class="flex items-center justify-between border-b py-2 px-2 tracking-wide">
                <span class="text-xs"><?php echo $notification->message; ?></span>
                <span class="bg-green-300 px-4 py-1 rounded-lg text-xs"><?php echo $notification->created_at; ?></span>
            </div>
        <?php } ?>
    </div>
</div>


<?php require ROOT . "/views/includes/footer.php"; ?>