<?php
class Evento {
    private static $eventosFile = __DIR__ . '/../config/eventos.php';

    public static function getAll() {
        return include self::$eventosFile;
    }

    public static function getById($id) {
        $eventos = self::getAll();
        foreach ($eventos as $evento) {
            if ($evento['id'] == $id) {
                return $evento;
            }
        }
        return null;
    }

    public static function create($nome, $data, $participantes) {
        $eventos = self::getAll();
        $novoEvento = [
            'id' => count($eventos) + 1,
            'nome' => $nome,
            'data' => $data,
            'participantes' => $participantes
        ];
        $eventos[] = $novoEvento;
        self::saveToFile($eventos);
    }

    public static function delete($id) {
        $eventos = array_filter(self::getAll(), function($evento) use ($id) {
            return $evento['id'] != $id;
        });
        $eventos = array_values($eventos);
        foreach ($eventos as $index => &$evento) {
            $evento['id'] = $index + 1;
        }
        self::saveToFile($eventos);
    }

    public static function update($id, $nome, $data, $participantes) {
        $eventos = self::getAll();
        foreach ($eventos as &$evento) {
            if ($evento['id'] == $id) {
                $evento['nome'] = $nome;
                $evento['data'] = $data;
                $evento['participantes'] = $participantes;
                break;
            }
        }
        self::saveToFile($eventos);
    }

    private static function saveToFile($eventos) {
        $conteudo = '<?php return ' . var_export($eventos, true) . ';';
        file_put_contents(self::$eventosFile, $conteudo);
    }
}