<?php

use Transip\Api\Library\Entity\Kubernetes\Taint;

require_once(__DIR__ . '/../Authenticate.php');

# Fill in your cluster name and node pool uuid
$clusterName = '';
$nodePoolUuid = '';

# Get a list of the current Taints
$taintList = $api->kubernetesTaints()->getAll($clusterName, $nodePoolUuid);

# Will output the current list of Taints
var_dump($taintList);

# Will add a noSchedule Taint to the list
$taintList[] = new Taint(['key' => 'test', 'value' => 'test', 'effect' => 'NoSchedule']);

# Push it to the TransIP API
$api->kubernetesTaints()->update($clusterName, $nodePoolUuid, $taintList);

# Get the updated list of Taints
$updatedTaintList = $api->kubernetesTaints()->getAll($clusterName, $nodePoolUuid);

# Outputs your updated list of Taints
var_dump($updatedTaintList);
