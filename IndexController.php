<?php

/**
 * Charge et renvoi le fichier HTML
 *
 * @param string $path
 *
 * @return SimpleXMLElement
 * @throws Exception
 */
function loadXML(string $path): SimpleXMLElement
{

    $fileData = file_get_contents($path);

    if (!$fileData)
    {
        throw new Exception('Le fichier ' . $path . ' n\'existe pas.');
    }

    $XMLData = simplexml_load_string($fileData);
    if (!$XMLData)
    {
        throw new Exception('Veuillez vérifié la syntaxe du fichier XML (' . $path . ')');
    }
    return $XMLData;
}

/**
 * Retourne le titre de la page demandée
 *
 * @param SimpleXMLElement $XML
 * @param int              $id
 *
 * @return string
 */
function getTitle(SimpleXMLElement $XML, int $id): string
{
    return $XML->page[$id]->title;
}

/**
 * Retourne le contenu de la page demandée
 *
 * @param SimpleXMLElement $XML
 * @param int              $id
 *
 * @return string
 */
function getContent(SimpleXMLElement $XML, int $id): string
{
    return $XML->page[$id]->content;
}

/**
 * Vérifie si la page demandée existe
 *
 * @param SimpleXMLElement $XML
 * @param int              $id
 *
 * @return bool
 */
function pageExist(SimpleXMLElement $XML, int $id): bool
{
    return isset($XML->page[$id]);
}

// Charge le fichier XML
$XML = loadXML('source.xml');

// Si un ID est défini est que il n'y a pas d'erreur
if (isset($_GET['id']) && is_numeric($_GET['id']) && !isset($_GET['e']))
{
    $id = $_GET['id'] - 1;
    // Vérifié si l'id de la page existe pour pouvoir récupérer son contenu
    if (pageExist($XML, $id))
    {
        $title = getTitle($XML, $id);
        $content = getContent($XML, $id);
    }
}