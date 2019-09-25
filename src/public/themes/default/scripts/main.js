/**
 * Set a random banner image in the header
 */
function randomBanner()
{
    // Get count of files in the banner directory
    let limit = 14;

    let rand = Math.floor(Math.random() * Math.floor(limit) + 1);
    let background = rand.toString() + ".gif";

    document.querySelector("#header-banner").style.backgroundImage = "url('/themes/default/media/banners/" + background + "')";
}

/**
 * Add onclick listener to post-image to link to full-size image
 */
function addImageLinkListener()
{
    $('.image-link').click(function(){
        window.location.href = this.src;
    });
}

window.onload = function()
{
    randomBanner();
    addImageLinkListener();
};