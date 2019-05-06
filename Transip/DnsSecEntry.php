<?php

/**
 * Models A DnsSecEntry
 *
 * @package Transip
 * @class DnsSecEntry
 * @author TransIP (support@transip.nl)
 */
class Transip_DnsSecEntry
{
	const ALGORITHM_DSA = 3;
	const ALGORITHM_RSASHA1 = 5;
	const ALGORITHM_DSA_NSEC3_SHA1 = 6;
	const ALGORITHM_RSASHA1_NSEC3_SHA1 = 7;
	const ALGORITHM_RSASHA256 = 8;
	const ALGORITHM_RSASHA512 = 10;
	const ALGORITHM_ECC_GOST = 12;
	const ALGORITHM_ECDSAP256SHA256 = 13;
	const ALGORITHM_ECDSAP384SHA384 = 14;
	const ALGORITHM_ED25519 = 15;
	const ALGORITHM_ED448 = 16;
	const FLAGS_NONE = 0;
	const FLAGS_ZSK = 256;
	const FLAGS_KSK = 257;
	const ALL_ALGORITHMS = array (
  0 => 3,
  1 => 5,
  2 => 6,
  3 => 7,
  4 => 8,
  5 => 10,
  6 => 12,
  7 => 13,
  8 => 14,
  9 => 15,
  10 => 16,
);
	const ALL_FLAGS = array (
  0 => 0,
  1 => 256,
  2 => 257,
);

	/**
	 * 
	 *
	 * @var int $keyTag
	 */
	public $keyTag;

	/**
	 * For all supported flags see Transip_DnsSecEntry::ALL_FLAGS
	 *
	 * @var int $flags
	 */
	public $flags;

	/**
	 * For all supported algorithms see Transip_DnsSecEntry::ALL_ALGORITHMS
	 *
	 * @var int $algorithm
	 */
	public $algorithm;

	/**
	 * 
	 *
	 * @var string $publicKey
	 */
	public $publicKey;

	/**
	 * DnsSecEntry constructor.
	 *
	 */
    public function __construct($keyTag, $flags, $algorithm, $publicKey)
    {
        $this->keyTag = $keyTag;
        $this->flags = $flags;
        $this->algorithm = $algorithm;
        $this->publicKey = $publicKey;
    }
}

?>
