<?php

/**
 *  Interface TransactionAdapter
 * Décrit les méthodes nécessaires à l'utilisation des Transactions.
 * 
 * @author CDB
 */
interface TransactionAdapter {
  /**
  * Commencer une transaction.
  */
  public function beginTransaction();
  /**
  * Enregistrer les modifications.
  */
  public function commit();
  /**
  * Annuler les modifications.
  */
  public function rollBack();
}
