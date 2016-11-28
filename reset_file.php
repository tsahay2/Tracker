<?php

$file = "uploads/Template.xlsx";
if (!unlink($file))
  {
  echo json_encode("Error deleting $file");
  }
else
  {
  echo json_encode("Deleted $file");
  }
?>