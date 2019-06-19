/**
 * Set up login page
 */
function loginSetup()
{
    let loginWindow = $('#login-window');

    // Add listener to login button
    loginWindow.submit(function () {
        $('#login-button').val("Logging in...");
    });

    // Set login page background
    loginWindow.parent().css('background-image', "url('../themes/admin/media/background.png')");
}

function notificationSetup()
{
    $('#notifications-dismiss').click(function(){$('#notifications').fadeOut()});
}

/**
 * Initialize date pickers
 */
function datePickerSetup()
{
    $('.date-input').datepicker({dateFormat: 'yy-mm-dd'});
}

/**
 * Filters a result table list
 * @param input The input field
 */
function filterTableList(input)
{
    // Get the input from the filter field
    let filter = input.value.toUpperCase();

    // Get the table immediately following the filter
    let table = input.nextElementSibling;
    let rows = table.getElementsByTagName("tr");

    for(let i = 0; i < rows.length; i++)
    {
        // Get second cell (after edit link)
        let cell = rows[i].getElementsByTagName("td")[1];

        if(cell)
        {
            if(cell.innerHTML.toUpperCase().indexOf(filter) > -1)
            {
                rows[i].style.display = "";
            }
            else
            {
                rows[i].style.display = "none";
            }
        }
    }
}

function tableFilterSetup()
{
    $('.list-table-filter').keyup(function(){
        filterTableList(this);
    });
}

function buttonSetup()
{
    $('.button').click(function(){
        veil();
    });

    $('.image-button').click(function(){
        veil();
    });
}

function formSubmitButtonSetup()
{
    $('.form-submit-button').click(function(){
        $('#' + $(this).attr('id') + '-form').submit();
    })
}

function confirmButtonSetup()
{
    $('.confirm-button').click(function(e){
        if(!confirm('Are you sure?'))
        {
            e.preventDefault();
            unveil();
        }
    });
}

function veil()
{
    $('#veil').show();
}

function unveil()
{
    $('#veil').hide();
}

function tinymceSetup()
{
    tinymce.init({
        selector: 'textarea#content-editor',
        height: 500,
        plugins: "code image lists link textcolor table",
        relative_urls:false,
        remove_script_host: false,
        convert_urls: false,
        toolbar: "formatselect | bold italic | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image | forecolor backcolor | table"
    });
}

/**
 * Setup document
 */
$(document).ready(function(){
    loginSetup();
    notificationSetup();
    tableFilterSetup();
    formSubmitButtonSetup();
    confirmButtonSetup();
    buttonSetup();
    datePickerSetup();
    tinymceSetup();

    // Fade in notifications if they are present
    $('#notifications').fadeIn();
});