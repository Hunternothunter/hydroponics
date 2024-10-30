<style>
    @media (max-width: 576px) {
    .text-wrapper {
        font-size: 0.8em;
    }

    .icon-wrapper i {
        font-size: 1.3em;
    }
}

/* Default icon styles */
.icon-wrapper {
    width: 60px;
    height: 40px;
    border-radius: 30px 30px 0 0;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s, color 0.3s;
    color: #7E7F9C; /* Default icon color */
}

.icon-wrapper i {
    color: inherit; /* Make the icon inherit the color from .icon-wrapper */
}

.icon-wrapper.active {
    background-color: #07244C;
}

.icon-wrapper.active i {
    color: #E5EAF3 !important; /* Active icon color */
}

.text-wrapper {
    display: block;
    width: 100%;
    border-radius: 5px 5px 0 0;
    color: #7E7F9C;
    text-align: center;
    transition: background-color 0.3s, color 0.3s;
}

.text-wrapper.active {
    background-color: #07244C;
    color: #E5EAF3;
}

</style>

<div class="d-block d-sm-none mt-5 pt-5">
    <div class="position-fixed bottom-0 start-0 end-0 border-top" style="z-index: 1050; background-color:#07244C; border-radius: 2.67rem 2.67rem 0 0;">
        <div class="container py-2">
            <div class="d-flex justify-content-around">
                <!-- Dashboard -->
                <div class="text-center">
                    <a href="index.php" class="<?php echo ($currentRoute === 'dashboard') ? 'nav-link active text-dark border-bottom border-3 border-white' : 'nav-link text-muted hover-link'; ?>">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-wrapper <?php echo ($currentRoute === 'dashboard') ? 'active' : ''; ?>">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'dashboard') ? 'active' : ''; ?>">Dashboard</span>
                        </div>
                    </a>
                </div>

                <!-- Controls -->
                <div class="text-center">
                    <a href="controls.php" class="<?php echo ($currentRoute === 'controls') ? 'nav-link active text-dark border-bottom border-3 border-white' : 'nav-link text-muted hover-link'; ?>">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-wrapper <?php echo ($currentRoute === 'controls') ? 'active' : ''; ?>">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'controls') ? 'active' : ''; ?>">Controls</span>
                        </div>
                    </a>
                </div>

                <!-- Historical Data -->
                <div class="text-center">
                    <a href="historical-data.php" class="<?php echo ($currentRoute === 'historical') ? 'nav-link active text-dark border-bottom border-3 border-white' : 'nav-link text-muted hover-link'; ?>">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-wrapper <?php echo ($currentRoute === 'historical') ? 'active' : ''; ?>">
                                <i class="fas fa-history"></i>
                            </div>
                            <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'historical') ? 'active' : ''; ?>">Historical Data</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
