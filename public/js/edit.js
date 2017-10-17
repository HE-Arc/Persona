function checkSelected(el) {
  var count = 0;
  var out_of_limit = false;

  for (var i=0, iLen=el.options.length; i<iLen; i++)
  {
      el.options[i].selected? count++ : null;

      // Deselect the option.
      if (count > 8) {
          el.options[i].selected = false;
          out_of_limit = true;
      }

  }
  if (out_of_limit)
    alert("Select only 8 qualities");
}
