/* Dashboard background slider */
.dashboard-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
}

.dashboard-bg::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.35));
    z-index: 2;
}

.dashboard-slide {
    position: absolute;
    inset: 0;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    opacity: 0;
    transition: opacity 1.8s ease-in-out;
    z-index: 1;
    filter: saturate(1.05) contrast(1.05);
}

.dashboard-slide.active {
    opacity: 1;
}
