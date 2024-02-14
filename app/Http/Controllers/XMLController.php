<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\XMLFile;

class XMLController extends Controller
{
    public function generateXML(Article $article)
    {
        // Пример за вземане на данните от модела на статията
        $specialty = $article->specialty;
        $scientificArea = $article->scientific_area;
        $title = $article->title;
        $abstract = $article->abstract;
        $keywordsArray = explode(',', $article->keywords);
        $fundingName = $article->funding_name;
        $grantId = $article->grant_id;

        // Пример за вземане на данни за авторите
        $authors = $article->authors()->get()->toArray();

        // Създаваме XML документ
        $xml = new \DOMDocument('1.0', 'utf-8');
        $xml->formatOutput = true;

        // Създаваме коренов елемент <article>
        $articleElement = $xml->createElement('article');
        $xml->appendChild($articleElement);

        // Добавяме елементите според полетата
        $specialtyElement = $xml->createElement('specialty', $specialty);
        $articleElement->appendChild($specialtyElement);

        $scientificAreaElement = $xml->createElement('scientific_area', $scientificArea);
        $articleElement->appendChild($scientificAreaElement);

        $titleElement = $xml->createElement('title', $title);
        $articleElement->appendChild($titleElement);

        $abstractElement = $xml->createElement('abstract', $abstract);
        $articleElement->appendChild($abstractElement);

        // KEYWORDS 
        // Създаваме елемент <ObjectList>
        $objectListElement = $xml->createElement('ObjectList');
        // Циклираме през всеки елемент от масива с ключови думи и създаваме XML елемент за всяка от тях
        foreach ($keywordsArray as $keyword) {
            // Създаваме XML елемент за ключовата дума
            $objectElement = $xml->createElement('Object');
            $objectElement->setAttribute('Type', 'keyword');

            // Създаваме XML елемент <Param> с атрибут Name="value" за стойността на ключовата дума
            $paramElement = $xml->createElement('Param', $keyword);
            $paramElement->setAttribute('Name', 'value');

            // Добавяме <Param> елемента към <Object> елемента
            $objectElement->appendChild($paramElement);

            // Добавяме <Object> елемента към <ObjectList> елемента
            $objectListElement->appendChild($objectElement);
        }
        // Добавяме <ObjectList> елемента към основния XML документ
        $articleElement->appendChild($objectListElement);

        // Добавяме елемент <funding_name>, ако има стойност за финансирането
        if (!empty($fundingName)) {
            $fundingNameElement = $xml->createElement('funding_name', $fundingName);
            $articleElement->appendChild($fundingNameElement);
        }

        // Добавяме елемент <grant_id>, ако има стойност за идентификационния номер на гранта
        if (!empty($grantId)) {
            $grantIdElement = $xml->createElement('grant_id', $grantId);
            $articleElement->appendChild($grantIdElement);
        }


        // Добавяме елементите за авторите
        foreach ($authors as $authorData) {
            $authorElement = $xml->createElement('author');
            $articleElement->appendChild($authorElement);

            $firstNameElement = $xml->createElement('first_name', $authorData['first_name']);
            $authorElement->appendChild($firstNameElement);

            $middleNameElement = $xml->createElement('middle_name', $authorData['middle_name']);
            $authorElement->appendChild($middleNameElement);

            $familyNameElement = $xml->createElement('family_name', $authorData['family_name']);
            $authorElement->appendChild($familyNameElement);

            $primaryAffiliationElement = $xml->createElement('primary_affiliation', $authorData['primary_affiliation']);
            $authorElement->appendChild($primaryAffiliationElement);

            $contactElement = $xml->createElement('contact', $authorData['contact_email']);
            $authorElement->appendChild($contactElement);

            $contributionsElement = $xml->createElement('contributions', $authorData['author_contributions']);
            $authorElement->appendChild($contributionsElement);
        }

        $xmlFileName = $article->id . ".xml";

        try {

            $xmlFilePath = $xmlFileName;
            $xml->save($xmlFilePath);

            // Създаване на XML файла в БД
            $xmlFile = new XMLFile();
            $xmlFile->filename = $xmlFileName;
            $xmlFile->content = $xml->saveXML();
            $xmlFile->article_id = $article->id;
            $xmlFile->save();


            // Activity LOG -  пише директно в модела
            return response()->json(['status' => 'success', 'message' => 'XML file created successfully']);
        } catch (\Exception $e) {
            // Activity LOG
            activity()
                ->performedOn(new XMLFile()) // model name
                ->withProperties(['xmlFIleError' => $article->id])
                ->log('XML file error');
            
            // При хвърлени изключения хващаме грешката и връщаме грешка със статус 500
            return response()->json(['status' => 'error', 'message' => 'Failed to create XML file: ' . $e->getMessage()], 500);
        }

    }
}
