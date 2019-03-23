/**
 * Set a random banner image in the header
 */
function randomBanner()
{
    // Get count of files in the banner directory
    let limit = 11;

    let rand = Math.floor(Math.random() * Math.floor(limit) + 1);
    let background = rand.toString() + ".gif";

    document.querySelector("#header-banner").style.backgroundImage = "url('../themes/default/media/banners/" + background + "')";
}

window.onload = function()
{
    randomBanner();
};