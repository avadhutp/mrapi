<?php
//Author: de77.com
//Homepage: http://de77.com
//Version: 23.01.2010
//Licence: MIT

class OpenCalais
{
	private $licenseId;
	private $data;

	public function __construct($licenseId)
	{
		$this->licenseId = $licenseId;
	}

	public function get($content)
	{
		$data['paramsXML'] =
		'<c:params xmlns:c="http://s.opencalais.com/1/pred/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<c:processingDirectives c:contentType="text/txt" c:enableMetadataType="GenericRelations,SocialTags" c:outputFormat="Application/JSON" c:docRDFaccesible="true" >
		</c:processingDirectives>
		<c:userDirectives c:allowDistribution="true" c:allowSearch="true" c:externalID="17cabs901" c:submitter="ABC">
		</c:userDirectives>
		<c:externalMetadata>
		</c:externalMetadata>
		</c:params>';

		$data['licenseID'] = $this->licenseId;
		$data['content'] = $content;

		$post = '';

		foreach ($data AS $name=>$value)
		{
			$post .= $name . '=' . urlencode($value) . '&';
		}

		$address = 'http://api.opencalais.com/enlighten/rest/';

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $address);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		if (!$res = curl_exec($c))
		{
			return false;
		}

		$this->data = json_decode($res);
		return $this;
	}

	public function getLanguage()
	{
		return $this->data->doc->meta->language;
	}

	public function getTopics()
	{
		$res = array();
		foreach ($this->data AS $d)
		{
			if (isset($d->_typeGroup) and $d->_typeGroup == 'topics')
			{
				$res[$d->categoryName] = $d->score;
			}
		}
		return $res;
	}

	public function getSocialTags()
	{
		$res = array();
		foreach ($this->data AS $d)
		{
			if (isset($d->_typeGroup) and $d->_typeGroup == 'socialTag')
			{
				$res[$d->name] = $d->importance;
			}
		}
		return $res;
	}

	public function getEntities()
	{
		$res = array();
		foreach ($this->data AS $d)
		{
			if (isset($d->_typeGroup) and $d->_typeGroup == 'entities')
			{
				$res[$d->_type][$d->name] = array('instances'=>$d->instances, 'relevance'=>$d->relevance);
			}
		}
		return $res;
	}


}