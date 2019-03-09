(function() {
  
  setTimeout(function() {
        $(".alert").fadeOut();
    }, 4000);

})();


var $collectionHolder;

// setup an "add a skill" link
var $addSkillLink = $('<a href="#" class="add_skill_link">Add a skill</a>');
var $newLinkLi = $('<li></li>').append($addSkillLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of speakers
    $collectionHolder = $('ul.skills');

    // add the "add a skill" anchor and li to the speakers ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addSkillLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new speaker form (see next code block)
        addSkillForm($collectionHolder, $newLinkLi);
    });
});



function addSkillForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a skill" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}