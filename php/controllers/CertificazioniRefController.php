<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{
  public function index(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $args['alunno_id'];

    $stmt = $mysqli_connection->prepare('SELECT * FROM certificazioni WHERE alunno_id = ?');
    $stmt->bind_param('i', $alunno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $args['alunno_id'];

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $stmt = $mysqli_connection->prepare('SELECT * FROM certificazioni WHERE alunno_id = ? AND id = ?');
    $stmt->bind_param('ii', $alunno_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response->getBody()->write(json_encode($result->fetch_all(MYSQLI_ASSOC)));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $args['alunno_id'];

    $data = json_decode($request->getBody(), true);

    if (!isset($data['titolo'])) {
      return $response->withStatus(401);
    }
    $titolo = $data['titolo'];

    if (!isset($data['votazione'])) {
      return $response->withStatus(401);
    }
    $votazione = $data['votazione'];

    if (!isset($data['ente'])) {
      return $response->withStatus(401);
    }
    $ente = $data['ente'];

    $stmt = $mysqli_connection->prepare('INSERT INTO certificazioni(alunno_id, titolo, votazione, ente) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('isis', $alunno_id, $titolo, $votazione, $ente);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }

  public function update(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $args['alunno_id'];

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $data = json_decode($request->getBody(), true);

    if (!isset($data['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $data['alunno_id'];

    if (!isset($data['titolo'])) {
      return $response->withStatus(401);
    }
    $titolo = $data['titolo'];

    if (!isset($data['votazione'])) {
      return $response->withStatus(401);
    }
    $votazione = $data['votazione'];

    if (!isset($data['ente'])) {
      return $response->withStatus(401);
    }
    $ente = $data['ente'];

    $stmt = $mysqli_connection->prepare('UPDATE alunni SET titolo = ?, votazione = ?, ente = ? WHERE alunno_id = ? AND id = ?');
    $stmt->bind_param('sisii', $titolo, $votazione, $ente, $alunno_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }

  public function destroy(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['alunno_id'])) {
      return $response->withStatus(401);
    }
    $alunno_id = $args['alunno_id'];

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $stmt = $mysqli_connection->prepare('DELETE FROM certificazioni WHERE alunno_id = ? AND id = ?');
    $stmt->bind_param('ii', $alunno_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }
}
