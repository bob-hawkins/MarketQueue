<?php if(isset($_SESSION["err"])) { ?>
    <div class="p-2">
    <p class="err text-center max-w-lg bg-red-500 text-white text-sm mx-auto p-2 rounded-none mb-4"><?php echo $_SESSION["err"]; ?></p>
    </div>
<?php unset($_SESSION["err"]); } ?>

<?php if(isset($_SESSION["success"])) { ?>
    <div class="p-2">
    <p class="err text-center max-w-lg bg-green-500 text-white text-sm mx-auto p-2 rounded-none mb-4"><?php echo $_SESSION["success"]; ?></p>
    </div>
    <?php unset($_SESSION["success"]); ?>
<?php } ?>