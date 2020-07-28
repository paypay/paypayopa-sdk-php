<?php
function loadFromDir($dirname)
{
    foreach (glob(__DIR__ . "/$dirname/*.php") as $filename) {
        require $filename;
    }
}

function loadClasses () {
    loadFromDir('helpers');
    loadFromDir('core');
    loadFromDir('Models');
    loadFromDir('Controllers');
};

loadClasses();